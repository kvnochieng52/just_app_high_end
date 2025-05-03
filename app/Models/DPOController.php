<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RazorInformatics\DPOPhp\Constants;
use RazorInformatics\DPOPhp\DPOPhp;
use RuntimeException;

class DPOController extends Model
{
    use HasFactory;

    /**
     * Process payment through DPO gateway
     */
    public function processPayment(Request $request)
    {



        $subscriptionID = $request['subscription'];
        $propertyID = $request['propertyID'];
        $paymentMethod = $request['paymentMethod'];
        $mpesaNumber = $request['mpesaNumber'];
        $airtelNumber = $request['airtelNumber'];
        $cardDetails = $request['cardDetails'];

        $subscriptionDetails = Subscription::where('id', $subscriptionID)->first();

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = Auth::user()->id;
        $userSubscription->start_date = Carbon::now();
        $userSubscription->end_date = Carbon::now()->addDays(30);
        $userSubscription->is_active = 0;
        $userSubscription->created_by = Auth::user()->id;
        $userSubscription->updated_by = Auth::user()->id;
        $userSubscription->subscription_id = $subscriptionID;
        $userSubscription->properties_count = !empty($propertyID) ? 1 : 0;
        $userSubscription->ref_property_id = $propertyID;
        $userSubscription->save();

        $dpo = new DPOPhp(config('services.dpo.company_token'));
        $customerDetails = Auth::user();
        $nameParts = $this->splitCustomerName($customerDetails->name);


        $serviceType = config('services.dpo.service_type_code');
        $reference = "INV-" . $userSubscription->id;
        $paymentAmount = $subscriptionDetails->amount;
        $customerFirstName = $nameParts['firstName'];
        $customerLastName = $nameParts['lastName'];
        $customerPhone = !empty($mpesaNumber) ? $this->formatPhoneNumber($mpesaNumber) : '';
        $customerEmail = $customerDetails->email;
        $description = 'Subscription Payment for ' . $customerDetails->name . ' for ' . $subscriptionDetails->sbscription_title;


        if ($paymentMethod == 'mobile_money') {

            $results = $dpo->payment()->chargeMpesa(
                $reference,
                $serviceType,
                $paymentAmount,
                $customerFirstName,
                $customerLastName,
                $customerPhone,
                $customerEmail,
                $description
            );

            if ($results['status'] == 'success') {

                $userSubscription->update([
                    'bpo_reference_no' => $results['data']['transRef'],
                    'bpo_token_no' => $results['data']['transToken']
                ]);

                return  redirect('/payment-processing?trans_id=' . $results['data']['transRef'] . '&property_id=' . $propertyID . '&subscription_id=' . $subscriptionID . '&payment_method=' . $paymentMethod);
            }

            return inertia('Payment/Error', [
                'error' => 'Payment initialization failed: ' . ($results['message'] ?? 'Unknown error')
            ]);
        }


        if ($paymentMethod == 'card') {

            $results = $dpo->payment()->card(
                $reference,
                $serviceType,
                $paymentAmount,
                preg_replace('/\s+/', '', $cardDetails['cardNumber']),
                str_replace('/', '', $cardDetails['expiry']),
                $cardDetails['cvv'],
                $cardDetails['firstName'],
                $cardDetails['lastName'],
                '',
                $customerEmail,
                env('CURRENCY'),
                $description
            );

            //  dd($results);

            if ($results['status'] == 'success') {

                $userSubscription->update([
                    'bpo_reference_no' => $results['data']['transRef'],
                    'bpo_token_no' => $results['data']['transToken']
                ]);

                return  redirect('/payment-processing?trans_id=' . $results['data']['transRef'] . '&property_id=' . $propertyID . '&subscription_id=' . $subscriptionID . '&payment_method=' . $paymentMethod);
            }

            return inertia('Payment/Error', [
                'error' => 'Payment initialization failed: ' . ($results['message'] ?? 'Unknown error')
            ]);
        }
    }

    /**
     * Check payment status with DPO
     */
    public function checkPaymentStatus(Request $request)
    {
        $reference = $request->input('reference');

        // Get the user subscription with this reference
        $userSubscription = UserSubscription::where('bpo_reference_no', $reference)->first();

        if (!$userSubscription) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found',
                'code' => '404'
            ], 404);
        }

        // Check with DPO API if payment was completed
        $dpo = new DPOPhp(config('services.dpo.company_token'));
        $status = $dpo->token()->verify($userSubscription->bpo_token_no);

        if ($status['status'] == 'success') {
            $resultCode = $status['data']['result'] ?? 'unknown';
            $explanation = $status['data']['resultExplanation'] ?? 'No explanation provided';

            // Update the subscription if payment is successful
            if ($resultCode === '000') {



                UserSubscription::where('user_subscriptions.user_id', Auth::user()->id)
                    ->where('user_subscriptions.is_active', 1)->update([
                        'is_active' => 0,

                    ]);


                $userSubscription->update([
                    'is_active' => '1',
                    'bpo_payment_status' => 'completed',
                    'bpo_payment_response' => json_encode($status['data'])
                ]);



                $refProperty = UserSubscription::where('bpo_reference_no', $userSubscription->bpo_reference_no)->first();


                if (!empty($refProperty->ref_property_id) && $refProperty->ref_property_id > 0) {

                    Property::where('id',  $refProperty->ref_property_id)->update([
                        'is_active' =>  PropertyStatuses::PENDING,
                        'updated_by' =>  Auth::user()->id,
                        'updated_at' => Carbon::now()->toDateTimeString(),
                        'prop_subscription_id' => UserSubscription::where('user_id', Auth::user()->id)->where('is_active', 1)->first()->id,
                    ]);
                }
            }

            return response()->json([
                'status' => $resultCode === '000' ? 'success' : 'pending',
                'message' => $explanation,
                'code' => $resultCode,
                'data' => $status['data']
            ]);
        }

        // Handle DPO API errors
        return response()->json([
            'status' => 'error',
            'message' => $status['message'] ?? 'Error verifying payment status',
            'code' => $status['data']['result'] ?? '500'
        ]);
    }

    /**
     * Split customer name into first and last name
     */
    protected function splitCustomerName(string $fullName): array
    {
        $nameParts = explode(' ', trim($fullName));

        $firstName = $nameParts[0] ?? '';
        $lastName = '';

        if (count($nameParts) > 1) {
            $lastName = implode(' ', array_slice($nameParts, 1));
        }

        return [
            'firstName' => $firstName,
            'lastName' => $lastName
        ];
    }

    /**
     * Format phone number for DPO (remove leading 0 and add 254)
     */
    protected function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Remove leading 0 if present
        if (strpos($cleaned, '0') === 0) {
            $cleaned = substr($cleaned, 1);
        }

        // Add 254 prefix if not already present
        if (strpos($cleaned, '254') !== 0) {
            $cleaned = '254' . $cleaned;
        }

        return $cleaned;
    }



    public function paymentSuccess(Request $request)
    {
        return inertia('Payment/Success', [
            'reference' => $request->query('reference')
        ]);
    }


    public function paymentFailed(Request $request)
    {


        //  dd($request['subscription_id'], $request['property_id']);
        return inertia('Payment/Failed', [
            'reference' => $request->query('reference'),
            'code' => $request->query('code'),
            'message' => urldecode($request->query('message')),
            'subscriptionID' => $request->query('subscription_id'),
            'propertyID' => $request->query('property_id')
        ]);
    }


    public function paymentProcessing(Request $request)
    {




        // dd($request['property_id']);
        return inertia('Payment/Processing')->with([
            'transactionReference' => $request['trans_id'],
            'propertyID' => $request['property_id'],
            'subscriptionDetails' => Subscription::where('id', $request['subscription_id'])->first(),
            'paymentMethod' => $request['payment_method'],
        ]);
    }



    public function chargeAirtel(string $reference, int $serviceType, float $paymentAmount, string $customerFirstName, string $customerLastName, string $customerAirtelPhoneNumber, string $customerEmail, string $description = '')
    {

        $token = $this->generateToken($reference, $serviceType, $paymentAmount, $customerFirstName, $customerLastName, $customerAirtelPhoneNumber, $customerEmail, 'KES', $description);

        if ($token['status'] === Constants::STATUS_ERROR) {
            return $token;
        }

        $xmlData = '<?xml version="1.0" encoding="UTF-8"?>
            <API3G>
               <CompanyToken>' . $this->companyToken . '</CompanyToken>
              <Request>ChargeTokenMobile</Request>
               <TransactionToken>' . $token['data']['transToken'] . '</TransactionToken>
              <PhoneNumber>' . $customerAirtelPhoneNumber . '</PhoneNumber>
              <MNO>airtel</MNO>
              <MNOcountry>kenya</MNOcountry>
            </API3G>';

        try {
            $response = json_decode($this->_transact($xmlData), false);
        } catch (RuntimeException $exception) {
            return $this->error($exception->getCode(), $exception->getMessage());
        }


        if (isset($response->StatusCode) && $response->StatusCode === "130") {
            return $this->success(['result' => $response->StatusCode, 'transToken' => $token['data']['transToken'], 'resultExplanation' => 'Request sent to Mpesa', 'transRef' => $token['data']['transRef'],]);
        }

        if (isset($response->Result)) {
            return $this->error($response->Result, (isset($response->ResultExplanation)) ? $response->ResultExplanation : "Unknown error occurred");
        }

        return $this->error(400, "Unknown error occurred");
    }
}
