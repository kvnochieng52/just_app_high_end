<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AppleNotificationController extends Controller
{
    public function handleNotification(Request $request)
    {
        $jwt = $request->input('signed_payload');


        try {
            $decoded = $this->verifyAppleJwt($jwt);

            // Process the decoded JWT
            if ($decoded->notification_type === 'account-delete') {
                $this->handleAccountDeletion($decoded);
            } elseif ($decoded->notification_type === 'consent-revoked') {
                $this->handleConsentRevoked($decoded);
            }

            return response()->json(['message' => 'Notification processed'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function verifyAppleJwt($jwt)
    {
        $keyData = $this->getKeyForJwt($jwt);
        $pemKey = $this->createPemFromKey($keyData);

        return JWT::decode($jwt, new Key($pemKey, 'RS256'));
    }

    private function getKeyForJwt($jwt)
    {
        $keys = Cache::remember('apple_public_keys', 86400, function () {
            return Http::get('https://appleid.apple.com/auth/keys')->json();
        });

        $header = JWT::jsonDecode(JWT::urlsafeB64Decode(explode('.', $jwt)[0]));
        $kid = $header->kid;

        foreach ($keys['keys'] as $key) {
            if ($key['kid'] === $kid) {
                return $key;
            }
        }

        throw new \Exception('No matching key found');
    }

    private function createPemFromKey($key)
    {
        $modulus = strtr($key['n'], '-_', '+/');
        $modulus = base64_decode($modulus);
        $exponent = strtr($key['e'], '-_', '+/');
        $exponent = base64_decode($exponent);

        $modulus = bin2hex($modulus);
        $exponent = bin2hex($exponent);

        return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode(pack('H*', '3082010A0282010100' . $modulus . '0203' . $exponent)), 64, "\n") . "-----END PUBLIC KEY-----";
    }

    private function handleAccountDeletion($data)
    {

        $appleUserId = $data->sub;

        // Use the 'sub' field to find and delete/deactivate the user in your database
        $user = User::where('apple_id', $appleUserId)->first();

        if ($user) {

            Property::where('created_by', $user->id)->delete();

            $user->delete();

            return response()->json(['message' => 'User account deleted successfully']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    private function handleConsentRevoked($data)
    {
        // Extract the user identifier (sub) from the notification
        $appleUserId = $data->sub;

        // Find the user by their Apple ID (sub field)
        $user = User::where('apple_id', $appleUserId)->first();

        if ($user) {
            // Make the user inactive by setting is_active to false
            $user->update(['is_active' => 0, 'consent_revoked' => 1]);

            Property::where('created_by', $user->id)->update(['is_active' => 0]);
            return response()->json(['message' => 'User consent revoked, account deactivated successfully']);
        }

        // Handle the case where the user is not found
        return response()->json(['error' => 'User not found'], 404);
    }
}
