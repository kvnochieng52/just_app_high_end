<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class AppleStoreService
{
    // Set your credentials here
    private $issuerId = '96957f3a-38ee-40a6-9503-afe9ac7bd5a1'; // Your Issuer ID
    private $keyId = 'UAQBXFZBZ6'; // Your Key ID
    private $privateKeyPath = 'AuthKey_UAQBXFZBZ6.p8'; // Path to your .p8 file
    private $bundleId = 'com.yourapp.bundle'; // Your app's bundle ID

    /**
     * Generate the JWT for authentication
     *
     * @return string
     */
    private function generateJWT()
    {
        // Get the private key from storage
        $privateKey = file_get_contents(storage_path($this->privateKeyPath));

        // Prepare the JWT claims
        $token = [
            'iss' => $this->issuerId,
            'exp' => time() + 3600,  // Expire after 1 hour
            'aud' => 'appstoreconnect-v1',  // Audience should be appstoreconnect-v1
            'bid' => $this->bundleId, // App's bundle ID
        ];

        // Encode and return the JWT token
        return JWT::encode($token, $privateKey, 'ES256', $this->keyId);
    }

    /**
     * Get app information or app stats from App Store Connect API
     *
     * @return array
     */
    public function getAppDownloads()
    {
        // Generate the JWT token
        $jwt = $this->generateJWT();

        // Make the request to App Store Connect API
        $response = Http::withHeaders([
            'Authorization' => "Bearer $jwt",
            'Accept' => 'application/json',
        ])->get('https://api.appstoreconnect.apple.com/v1/apps');

        // Check if the response is successful
        if ($response->successful()) {
            return $response->json(); // Return the data from the API response
        } else {
            // Handle the error (you can log this for debugging)
            return [
                'error' => 'Failed to fetch data from App Store Connect API',
                'status' => $response->status(),
                'message' => $response->body(),
            ];
        }
    }
}
