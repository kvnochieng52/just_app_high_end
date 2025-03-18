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
        $paystackSecretKey = "sk_live_ee65824f1502b565ea9fb14c6507d2f7da651539";
        $callbackUrl = "http://127.0.0.1:8000/paystack/callback";


        // $email = $_POST["email"];
        $amount = $amount * 100; // Convert to kobo (Paystack uses kobo)



        $postData = [
            "email" => $email,
            "amount" => $amount,
            "currency" => "KES",
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
}
