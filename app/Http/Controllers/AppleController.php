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
    public function handleProviderCallback(Request $request)
    {
        try {
            // Get token from the Flutter app
            $identityToken = $request->input('token');
            if (!$identityToken) {
                return response()->json(['error' => 'Token not provided.'], 400);
            }

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
            // Return the error message for debugging
            return response()->json(['error' => 'Login failed. ' . $e->getMessage()], 400);
        }
    }

    // Verify the Apple token using Firebase JWT
    protected function verifyAppleToken($identityToken)
    {
        try {
            // Fetch Apple's public keys
            $appleKeys = file_get_contents('https://appleid.apple.com/auth/keys');
            if (!$appleKeys) {
                throw new \Exception('Unable to retrieve Apple public keys.');
            }

            $publicKeys = json_decode($appleKeys, true);

            if (!isset($publicKeys['keys'][0])) {
                throw new \Exception('Invalid public key format.');
            }

            // Parse the JWK (JSON Web Key) into RSA keys
            $rsaKeys = JWK::parseKeySet($publicKeys);

            // Decode the identity token using the RSA key and RS256 algorithm
            $decodedToken = JWT::decode($identityToken, $rsaKeys);

            // Check the structure of the decoded token
            if (!is_object($decodedToken)) {
                throw new \Exception('Invalid token structure.');
            }

            return $decodedToken;
        } catch (\Exception $e) {
            // Return the error message for debugging
            throw new \Exception('Token verification failed: ' . $e->getMessage());
        }
    }
}
