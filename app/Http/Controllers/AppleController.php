<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AppleController extends Controller
{
    // Endpoint to handle the callback after Apple sign-in
    public function handleProviderCallback(Request $request)
    {
        try {
            // Get token from the Flutter app
            $identityToken = $request->input('token');

            // Verify the Apple token with Apple's public key
            $appleUser = $this->verifyAppleToken($identityToken);

            if (!$appleUser) {
                return response()->json(['error' => 'Invalid Apple token.'], 400);
            }

            // Check if the user already exists based on Apple ID
            $user = User::where('apple_id', $appleUser->sub)->first();

            if (!$user) {
                // If the user does not exist, create a new one
                $user = User::create([
                    'name' => $appleUser->name ?? 'Apple User', // Name may not always be available
                    'email' => $appleUser->email ?? null, // Email might also be null
                    'apple_id' => $appleUser->sub, // Use the sub as the Apple user ID
                    'password' => bcrypt(Str::random(16)), // Generate a random password
                ]);
            }

            // Log the user in
            Auth::login($user);

            // Generate a token (using Laravel Sanctum or Passport)
            $token = $user->createToken('AppleSignInToken')->plainTextToken;

            // Return a response with user data and token
            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'Login failed. Please try again.'], 400);
        }
    }

    // Verify the Apple token using Firebase JWT
    protected function verifyAppleToken($identityToken)
    {
        try {
            $appleKeys = file_get_contents('https://appleid.apple.com/auth/keys'); // Fetch Apple's public keys
            $publicKeyData = json_decode($appleKeys, true);

            // Assuming you're working with RS256 algorithm
            $jwtDecoded = JWT::decode($identityToken, new Key($publicKeyData['keys'][0]['n'], 'RS256'));

            return $jwtDecoded; // The decoded token which contains the user's Apple info
        } catch (\Exception $e) {
            return null;
        }
    }
}
