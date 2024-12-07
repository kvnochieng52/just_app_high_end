<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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


            Log::info('Login appleUser: ' . json_encode($appleUser));

            if (!$appleUser) {
                return response()->json(['error' => 'Invalid Apple token.'], 400);
            }

            // Check if the user already exists based on Apple ID
            $user = User::where('apple_id', $appleUser->sub)->first();

            if (!$user) {
                // If the user does not exist, create a new one
                $user = User::create([
                    'name' => $this->getAppleUserName($appleUser),
                    'email' => $appleUser->email ?? null,
                    'apple_id' => $appleUser->sub,
                    'password' => bcrypt(Str::random(16)),
                    'is_active' => 1,
                ]);

                DB::table('model_has_roles')->insert([
                    'role_id' => 2,
                    'model_type' => 'App\Models\User',
                    'model_id' => $user->id,
                ]);
            } else {
                // Optionally, update the user's name and email if they are provided and the user does not have them
                if (empty($user->email) && !empty($appleUser->email)) {
                    $user->email = $appleUser->email;
                }

                if (empty($user->name) && (!empty($appleUser->name) || !empty($appleUser->email))) {
                    $user->name = $this->getAppleUserName($appleUser);
                }

                $user->save();
            }

            // Log the user in
            Auth::login($user);

            // Generate a token (using Laravel Sanctum or Passport)
            $token = $user->createToken('AppleSignInToken')->plainTextToken;

            return [
                'success' => true,
                'message' => 'Successfully Logged in...',
                'data' => $user,
                'token' => $token,
            ];
        } catch (\Exception $e) {
            Log::info('Login failed: ' . $e->getMessage());
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
            throw new \Exception('Token verification failed: ' . $e->getMessage());
        }
    }

    // Helper function to get the user's name from the Apple user object
    protected function getAppleUserName($appleUser)
    {
        if (!empty($appleUser->name)) {
            return $appleUser->name;
        } elseif (!empty($appleUser->email)) {
            return explode('@', $appleUser->email)[0];
        } else {
            return 'Apple User';
        }
    }
}
