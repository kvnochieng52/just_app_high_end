<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyStatuses;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    public function initiatePayment(Request $request)
    {

        $paystackPublicKey = "pk_live_d0572a92a218942399656df9280dc12f0d0feb5f";
        $paystackSecretKey = "sk_live_ee65824f1502b565ea9fb14c6507d2f7da651539";
        $callbackUrl = "http://127.0.0.1:8000/paystack/callback";


        $name = "Kevin Ochieng";
        $email = "kvnochieng52@gmail.com";
        $amount = 5;



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

        if ($result["status"]) {
            header("Location: " . $result["data"]["authorization_url"]);
            exit();
        } else {
            echo "Payment initialization failed: " . $result["message"];
        }
    }

    public function handleCallback()
    {


        $paystackPublicKey = "pk_live_d0572a92a218942399656df9280dc12f0d0feb5f";
        $paystackSecretKey = "sk_live_d05f976d0f08c94ef8587b3dd59ccc1274a54e90";
        //$callbackUrl = "http://127.0.0.1:8000/paystack/callback";

        if (!isset($_GET["reference"])) {
            die("No payment reference provided.");
        }

        $reference = $_GET["reference"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . $reference);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $paystackSecretKey,
            "Content-Type: application/json",
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result["status"] && $result["data"]["status"] === "success") {

            UserSubscription::where('user_subscriptions.user_id', Auth::user()->id)
                ->where('user_subscriptions.is_active', 1)->update([
                    'is_active' => 0,

                ]);

            UserSubscription::where('paystack_reference_no', $reference)->update([
                'is_active' => 1,
                'updated_by' =>  Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'trans_id' => $result["data"]["id"]
            ]);

            Property::where('id', UserSubscription::where('paystack_reference_no', $reference)->first()->ref_property_id)->update([
                'is_active' =>  PropertyStatuses::PENDING,
                'updated_by' =>  Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            // echo "Payment successful! Transaction ID: " . $result["data"]["id"];
            return redirect('/dashboard/listing')->with('success', 'Payment Processed Successfully.');
        } else {
            return redirect('/dashboard')->with('error', 'Payment not Processed.');
        }
    }
}
