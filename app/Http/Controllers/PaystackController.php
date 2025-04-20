<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyStatuses;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    // public function initiatePayment(Request $request)
    // {

    //     $paystackPublicKey = "pk_live_d0572a92a218942399656df9280dc12f0d0feb5f";
    //     $paystackSecretKey = "sk_live_ee65824f1502b565ea9fb14c6507d2f7da651539";
    //     $callbackUrl = "http://127.0.0.1:8000/paystack/callback";


    //     $name = "Kevin Ochieng";
    //     $email = "kvnochieng52@gmail.com";
    //     $amount = 5;



    //     // $email = $_POST["email"];
    //     $amount = $amount * 100; // Convert to kobo (Paystack uses kobo)



    //     $postData = [
    //         "email" => $email,
    //         "amount" => $amount,
    //         "currency" => "KES",
    //         "callback_url" => $callbackUrl,
    //     ];

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/initialize");
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         "Authorization: Bearer " . $paystackSecretKey,
    //         "Content-Type: application/json",
    //     ]);

    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $result = json_decode($response, true);

    //     if ($result["status"]) {
    //         header("Location: " . $result["data"]["authorization_url"]);
    //         exit();
    //     } else {
    //         echo "Payment initialization failed: " . $result["message"];
    //     }
    // }

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
                'trans_id' => $result["data"]["id"],
            ]);


            $refProperty = UserSubscription::where('paystack_reference_no', $reference)->first();


            if (!empty($refProperty->ref_property_id)) {

                Property::where('id',  $refProperty->ref_property_id)->update([
                    'is_active' =>  PropertyStatuses::PENDING,
                    'updated_by' =>  Auth::user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'prop_subscription_id' => UserSubscription::where('user_id', Auth::user()->id)->where('is_active', 1)->first()->id,
                ]);

                $propertDetails = Property::getPropertyByID($refProperty->ref_property_id);
                Mail::send(
                    'mailing.admin.admins_notify',
                    [
                        'property_title' => $propertDetails->property_title,
                        'created_by_name' => $propertDetails->created_by_name,
                        'address' => $propertDetails->google_address,
                    ],
                    function ($message) use ($propertDetails) {

                        $adminEmails = DB::table('model_has_roles')->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                            ->where('role_id', 1)
                            ->where('users.email', '!=', null)
                            ->pluck('users.email')
                            ->toArray();
                        $adminEmails[] = 'thejustgrouplimited@gmail.com';


                        $subject =  'POSTED ' . ": {$propertDetails->property_title} Requires Approval";
                        $message->from('app@justhomesapp.com', 'Just Homes');
                        $message->to($adminEmails);
                        $message->subject($subject);
                    }
                );
                // echo "Payment successful! Transaction ID: " . $result["data"]["id"];
                return redirect('/dashboard/listing')->with('success', 'Payment Processed Successfully.');
            } else {
                return redirect('/dashboard')->with('success', 'Payment Processed Successfully.');
            }
        } else {
            return redirect('/dashboard')->with('error', 'Payment not Processed.');
        }
    }
}
