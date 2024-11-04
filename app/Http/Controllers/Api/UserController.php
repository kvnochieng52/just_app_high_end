<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function socialMediaLogin(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->provider_id = $request['user_id'];
            $user->avatar = $request['profile_photo'];
            $user->is_active = 1;
            $user->save();

            DB::table('model_has_roles')->insert([
                'role_id' => 2,
                'model_type' => 'Models\User',
                'model_id' => $user->id,
            ]);
        }

        return [
            'success' => true,
            'message' => 'Successfully Logged in...',
            'data' => $user
        ];
    }


    public function login(Request $request)
    {
        $results = [];

        $credentials = $request->only(['email', 'password']);

        // Check if input is email or telephone
        if (filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $loginField = 'email';
        } else {
            $loginField = 'telephone';
        }

        if (Auth::attempt([$loginField => $credentials['email'], 'password' => $credentials['password']])) {
            $user_details = User::find(Auth::id());

            if ($user_details->is_active == 1) {
                return [
                    'success' => true,
                    'activated' => '1',
                    'data' => $user_details,
                    'message' => 'User Successfully Logged in'
                ];
            } else {
                return [
                    'success' => true,
                    'activated' => '0',
                    'data' => [
                        'user_details' => $user_details,
                    ],
                    'message' => 'Your Account is not Activated. Please Activate the Account'
                ];
            }
        } else {
            return [
                'success' => false,
                'data' => [],
                'message' => 'Credentials do not match. Please check and try again'
            ];
        }
    }




    public function register(Request $request)
    {
        $results = [];
        $user_check = User::where('email', $request['email'])
            ->orWhere('telephone', $request['telephone'])
            ->first();

        if (!empty($user_check)) {

            return [
                'success' => false,
                'data' => [],
                'message' => 'The email or telephone provided is registered. Please login/reset password'
            ];
        } else {

            $randomNumber = random_int(1000, 9999);
            $user = new User();

            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->telephone = $request['telephone'];
            $user->is_active = 0;
            $user->password = Hash::make($request['password']);
            $user->activation_code = $randomNumber;
            $user->save();


            DB::table('model_has_roles')->insert([
                'role_id' => 2,
                'model_type' => 'Models\User',
                'model_id' => $user->id,
            ]);


            Mail::send(
                'mailing.register.register',
                [
                    'resetCode' => $randomNumber,
                    'name' => $request['name'],
                ],
                function ($message) use ($request) {
                    $message->from('noreply@justhomes.co.ke', 'Just Homes');
                    $message->to($request['email'])->subject("Activate Account: Just Homes.");
                }
            );

            return [
                'success' => true,
                'data' => $user,
                'message' => 'User Successfully Registered, Please Activate your account to continue'
            ];
        }
    }



    public function updateProfile(Request $request)
    {
        User::where('id', $request['user_id'])->update([
            'name'  => $request['name'],
            'email'  => $request['email'],
            'telephone'  => $request['telephone'],
            'company_name'  => $request['company'],
            //'website'  => $request['website'],
            'facebook'  => $request['facebook'],
            'tiktok'  => $request['tiktok'],
            'twitter'  => $request['twitter'],
            // 'linkedin'  => $request['linkedin'],
            'profile'  => $request['profile'],
            'updated_by' => $request['user_id'],
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);


        return [
            'success' => true,
            //'data' => $user,
            'message' => 'Profile successfully Updated'
        ];
    }


    public function updatePassword(Request $request)
    {
        User::where('id', $request['user_id'])->update([
            'email'  => $request['email'],
            'password'  => Hash::make($request['password']),
        ]);

        return [
            'success' => true,
            //'data' => $user,
            'message' => 'Password successfully Updated'
        ];
    }


    public function forgotPassword(Request $request)
    {

        $email = $request['email'];

        $checkEmail = User::where('email', $email)->first();

        if (!empty($checkEmail)) {

            $randomNumber = random_int(1000, 9999);

            User::where('id', $checkEmail->id)->update([
                'reset_code' => $randomNumber,
            ]);


            Mail::send(
                'mailing.password.forgot',
                [
                    'resetCode' => $randomNumber,
                    'name' => $checkEmail->name,
                ],
                function ($message) use ($request, $checkEmail) {
                    $message->from('noreply@justhomes.co.ke', 'Just Homes');
                    $message->to($checkEmail->email)->subject("Reset password: Just Homes.");
                }
            );

            return response()->json([
                "success" => true,
                "message" => 'Email Reset Code sent. Check your Email for the instructions',
                "data" => [
                    'resetCode' => $randomNumber,
                    'userDetails' => $checkEmail,

                ],

            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => 'Email does not exist. Please check email and try again',

            ]);
        }
    }


    public function resetPassword(Request $request)
    {

        try {
            // Hash the password before updating
            User::where('id', $request->input('user_id'))->update([
                'password' => Hash::make($request->input('password')),
                //  'reset_code' => null,
                'updated_by' => $request['user_id'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password successfully updated.',
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occur
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the password.',
            ], 500);
        }
    }


    public function activateAccount(Request $request)
    {
        $userID = $request['user_id'];
        $activationCode = $request['activation_code'];

        User::where(['id' => $userID, 'activation_code' => $activationCode])->update([
            'is_active' => 1,
        ]);

        $userDetails = User::where('id', $userID)->first();

        self::welcomeEmail($userDetails);


        return response()->json([
            "success" => true,
            "message" => 'Account Activated. Please Login to continue',
        ]);
    }



    public function resendActivateCode(Request $request)
    {
        $userID = $request['user_id'];


        $userDetails = User::where('id', $userID)->first();

        Mail::send(
            'mailing.register.register',
            [
                'resetCode' => $userDetails->activation_code,
                'name'  => $userDetails->name,
            ],
            function ($message) use ($userDetails) {
                $message->from('noreply@justhomes.co.ke', 'Just Homes');
                $message->to($userDetails->email)->subject("Activate Account: Just Homes.");
            }
        );

        return response()->json([
            "success" => true,
            "message" => 'Code Sent. Please check email and enter the code',
        ]);
    }



    public function resendVerifyCode(Request $request)
    {
        $userID = $request['user_id'];


        $userDetails = User::where('id', $userID)->first();

        Mail::send(
            'mailing.password.forgot',
            [
                'resetCode' => $userDetails->reset_code,
                'name' => $userDetails->name,
            ],
            function ($message) use ($request, $userDetails) {
                $message->from('noreply@justhomes.co.ke', 'Just Homes');
                $message->to($userDetails->email)->subject("Reset password: Just Homes.");
            }
        );

        return response()->json([
            "success" => true,
            "message" => 'Code Sent. Please check email.',
        ]);
    }


    public static function welcomeEmail($userDetails)
    {

        try {
            Mail::send(
                'mailing.register.welcome',
                [
                    'name' => $userDetails->name,
                ],
                function ($message) use ($userDetails) {
                    $message->from('noreply@justhomes.co.ke', 'Just Homes');
                    $message->to($userDetails->email)->subject("Welcome | Karibu to Just Homes.");
                }
            );
            // Log success or handle successful email sending if needed
        } catch (\Exception $e) {
            // Log the error message for debugging
            return  'Failed to send welcome email: ' . $e->getMessage();

            // Optionally, you can notify admins or users about the failure
            // Example: 
            // \Mail::raw('There was an error sending the welcome email: ' . $e->getMessage(), function($message) {
            //     $message->to('admin@justhomes.co.ke')->subject('Email Sending Failure');
            // });
        }
    }



    public function deleteProfile(Request $request)
    {
        $userID = $request['user_id'];

        Property::where('created_by', $userID)->delete();
        Favorite::where('user_id', $userID)->delete();
        Calendar::where('user_id', $userID)->delete();
        Message::where('user_id', $userID)->delete();
        User::where('id', $userID)->delete();

        return response()->json([
            "success" => true,
            "message" => 'User Profile Deleted',
        ]);
    }


    public function uploadCompanyLogo(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate logo file
        ]);

        // Retrieve the user by ID
        $user = User::findOrFail($request->user_id);

        // Check if there's an existing logo and delete it
        if ($user->company_logo && file_exists(public_path($user->company_logo))) {
            unlink(public_path($user->company_logo)); // Delete existing logo
        }

        // Move the new logo file to the public/company_logos folder
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = 'company_logos/' . $filename;
        $file->move(public_path('company_logos'), $filename);

        // Update the user's logo path in the database
        $user->company_logo = $filePath;
        $user->save();

        return response()->json([
            'message' => 'Company logo uploaded successfully',
            'company_logo_url' => asset($filePath) // Return the public URL of the logo
        ], 200);
    }




    public function uploadProfilePhoto(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate logo file
        ]);

        // Retrieve the user by ID
        $user = User::findOrFail($request->user_id);

        // Check if there's an existing logo and delete it
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar)); // Delete existing logo
        }

        // Move the new logo file to the public/company_logos folder
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = 'uploads/images/' . $filename;
        $file->move(public_path('uploads/images'), $filename);

        // Update the user's logo path in the database
        $user->avatar = $filePath;
        $user->save();

        return response()->json([
            'message' => 'Company logo uploaded successfully',
            'company_logo_url' => asset($filePath) // Return the public URL of the logo
        ], 200);
    }
}
