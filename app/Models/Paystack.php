<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;

class Paystack extends Model
{
    use HasFactory;


    public static function initiatePayment($email, $amount)
    {



        $paystackPublicKey = "pk_live_d0572a92a218942399656df9280dc12f0d0feb5f";
        $paystackSecretKey = "sk_live_d05f976d0f08c94ef8587b3dd59ccc1274a54e90";

        $callbackUrl = "https://justhomes.co.ke/paystack/callback";


        // $callbackUrl = env('PAYSTACK_CALLBACK_URL');

        // $email = $_POST["email"];
        $amount = $amount * 100; // Convert to kobo (Paystack uses kobo)


        $country = env('COUNTRY');


        if ($country == 'KENYA') {
            $currency = env('CURRENCY', 'KES');
            $amount = $amount;
        } else {
            $currency = 'USD';
            $amount = self::convertCurrency(env('CURRENCY'), $amount,  'USD');
        }



        $postData = [
            "email" => $email,
            "amount" => $amount,
            "currency" => $currency,
            "callback_url" => $callbackUrl,
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/initialize");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $paystackSecretKey,
            "Content-Type: application/json",
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return $result;
    }




    public static function convertCurrency($fromCurrency, $amount, $toCurrency = 'USD')
    {
        // Example exchange rates relative to 1 USD
        $exchangeRates = [
            'NGN' => 1400.00,
            'TZS' => 2500.00,
            'UGX' => 3800.00,
            'USD' => 1.00,
        ];

        // Check if both currencies exist in our rates list
        if (!isset($exchangeRates[$fromCurrency]) || !isset($exchangeRates[$toCurrency])) {
            return "Unsupported currency.";
        }

        // Convert from base currency to USD first, then to target currency
        $amountInUSD = $amount / $exchangeRates[$fromCurrency];
        $convertedAmount = $amountInUSD * $exchangeRates[$toCurrency];

        return round($convertedAmount, 2);
    }
}
