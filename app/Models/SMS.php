<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class SMS extends Model
{
    /**
     * Send an SMS using the AdvantaSMS API.
     *
     * @param string $to       Receiver's phone number
     * @param string $message  Message body
     * @return array
     */
    public static function sendSms($to, $message)
    {
        $cleanedNumber = self::formatPhoneNumber($to);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://quicksms.advantasms.com/api/services/sendsms/', [
            'apikey'    => env('ADVANTA_SMS_API_KEY'),
            'partnerID' => env('ADVANTA_SMS_PARTNER_ID'),
            'message'   => $message,
            'shortcode' => env('ADVANTA_SMS_SHORTCODE'),
            'mobile'    => $cleanedNumber,
        ]);

        return [
            'status' => $response->successful(),
            'body'   => $response->json(),
        ];
    }

    /**
     * Format a phone number to international format (2547XXXXXXXX).
     *
     * @param string $phone
     * @return string
     */
    private static function formatPhoneNumber($phone)
    {
        // Remove all non-digit characters
        $phone = preg_replace('/\D+/', '', $phone);

        // Remove leading zero
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }

        // Remove leading 254 if it's already there (to avoid duplication)
        if (substr($phone, 0, 3) === '254') {
            $phone = substr($phone, 3);
        }

        // Final number in format: 2547XXXXXXXX
        return '254' . $phone;
    }
}
