<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user_details = User::find(Auth::id());
            if ($user_details->is_active == 1) {
                return [
                    'success' => true,
                    'data' => $user_details,
                    'message' => 'User Succefully Logged in'
                ];
            } else {
                return [
                    'success' => false,
                    'data' => [],
                    'message' => 'Your Account is not Activated'
                ];
            }
        } else {
            return [
                'success' => false,
                'data' => [],
                'message' => 'Credentials do not march. Please check and Try again'
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
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->telephone = $request['telephone'];
            $user->is_active = 1;
            $user->password = Hash::make($request['password']);
            $user->save();


            DB::table('model_has_roles')->insert([
                'role_id' => 2,
                'model_type' => 'Models\User',
                'model_id' => $user->id,
            ]);


            return [
                'success' => true,
                'data' => $user,
                'message' => 'User Successfully Registered, Please login to continue'
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
                    $message->from('noreply@justhomes.co.ke');
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
}
