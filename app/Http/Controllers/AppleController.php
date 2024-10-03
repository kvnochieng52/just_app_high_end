<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


class AppleController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('apple')->redirect();
        //tets
    }


    public function handleProviderCallback(Request $request)
    {
        try {
            // Get the user information from Apple
            $appleUser = Socialite::driver('apple')->user();

            // Check if the user already exists in your database
            $user = User::where('apple_id', $appleUser->id)->first();

            if (!$user) {
                // If the user does not exist, create a new one
                $user = User::create([
                    'name' => $appleUser->name, // Assuming the name is available
                    'email' => $appleUser->email,
                    'apple_id' => $appleUser->id, // Store the Apple ID
                    'password' => bcrypt(Str::random(16))
                    // Add other fields as necessary
                ]);
            }

            // Log the user in
            Auth::login($user);

            // Generate a token (if you are using Laravel Sanctum or Passport)
            $token = $user->createToken('Apple SignIn Token')->plainTextToken; // For Laravel Sanctum
            // or use Passport for JWT token
            // $token = $user->createToken('AppleSignIn')->accessToken;

            // Return a response with user data and token
            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions, e.g., redirect to a login page with an error message
            return response()->json(['error' => 'Login failed. Please try again.'], 400);
        }
    }
}
