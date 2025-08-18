<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyAdminsOfPostedProperty;
use App\Models\Property;
use App\Models\PropertyStatuses;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function getSubscriptions(Request $request)
    {
        try {
            $subscriptions = Subscription::where('is_active', 1)->get();
            $userDetails = User::where('id', $request['user_id'])->first();

            $userActiveSubscription = UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
                ->where('user_subscriptions.user_id',  $request['user_id'])
                ->where('user_subscriptions.is_active', 1)
                ->orderBy('user_subscriptions.id', 'DESC')
                //  ->select('user_subscriptions.*', 'subscriptions.name as subscription_name')
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Subscriptions retrieved successfully',
                'data' => $subscriptions,
                'userDetails' => $userDetails,
                'userActiveSubscription' => $userActiveSubscription,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve subscriptions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSubscriberActiveSubscription(Request $request)
    {
        try {
            $userID = $request->input('user_id');

            if (!$userID) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }

            $userActiveSubscription = UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
                ->where('user_subscriptions.user_id', $userID)
                ->where('user_subscriptions.is_active', 1)
                ->orderBy('user_subscriptions.id', 'DESC')
                //  ->select('user_subscriptions.*', 'subscriptions.name as subscription_name')
                ->first();

            if ($userActiveSubscription) {
                return response()->json([
                    'success' => true,
                    'message' => 'Active subscription found',
                    'data' => $userActiveSubscription
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve active subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function processSubscription(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $propertyID = $request->input('propertyID');

            $userActiveSubscription = UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
                ->where('user_subscriptions.user_id', $userID)
                ->where('user_subscriptions.is_active', 1)
                ->orderBy('user_subscriptions.id', 'DESC')
                ->first([
                    'subscriptions.*',
                    'user_subscriptions.properties_count',
                    'user_subscriptions.id as prop_subscription_id'
                ]);

            if ($userActiveSubscription) {

                $incomingCount = $userActiveSubscription->properties_count + 1;

                if ($incomingCount <= $userActiveSubscription->properties_post_count || $userActiveSubscription->properties_post_count == -1) {

                    if ($propertyID != null && $propertyID > 0) {


                        UserSubscription::where('user_id', $userID)
                            ->where('is_active', 1)->update([
                                'properties_count' => $userActiveSubscription->properties_count + 1,
                            ]);

                        Property::where('id', $propertyID)->update([
                            'is_active' => PropertyStatuses::PENDING,
                            'prop_subscription_id' => $userActiveSubscription->prop_subscription_id
                        ]);

                        NotifyAdminsOfPostedProperty::dispatch($propertyID);
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Property Posted',
                        'data' => ''
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'You dont have an active subscription',
                        'data' => ''
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You dont have an active subscription',
                    'data' => ''
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve active subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function processPayment(Request $request)
    {
        $refNo = $request['uniqueTransRef'];
        $propertyID = $request['propertyID'];
        $userID = $request['user_id'];
        $subscription = $request['subscription_id'];

        if ($subscription == 1) {
            UserSubscription::where('user_id', $userID)
                ->where('is_active', 1)->update([
                    'is_active' => 0,
                ]);

            $userSubscription = new UserSubscription();
            $userSubscription->user_id =  $userID;
            $userSubscription->start_date = Carbon::now();
            $userSubscription->end_date = Carbon::now()->addDays(30);
            $userSubscription->is_active = 1;
            $userSubscription->created_by =   $userID;
            $userSubscription->updated_by =   $userID;
            $userSubscription->subscription_id = $subscription;
            $userSubscription->properties_count = ($request['propertyID'] != null && $request['propertyID'] > 0) ?  1 : 0;
            $userSubscription->ref_property_id = $request['propertyID'];
            $userSubscription->save();

            if ($request['propertyID'] != null && $request['propertyID'] > 0) {
                Property::where('id', $propertyID)->update([
                    'is_active' =>  PropertyStatuses::PENDING,
                    'updated_by' => $userID,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'prop_subscription_id' => $userSubscription->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Subscription initiated',
                'data' => ''
            ], 200,);
        } else {
            // paid plan

            $subscriptionDetails = Subscription::where('id', $subscription)->first();

            $email = User::where('id', $userID)->first()->email;
            $amount = $subscriptionDetails->amount;

            $userSubscription = new UserSubscription();
            $userSubscription->user_id = $userID;
            $userSubscription->start_date = Carbon::now();
            $userSubscription->end_date = Carbon::now()->addDays(30);
            $userSubscription->is_active = 0;
            $userSubscription->created_by =  $userID;
            $userSubscription->updated_by =  $userID;
            $userSubscription->subscription_id = $subscription;
            $userSubscription->paystack_reference_no = $refNo;
            $userSubscription->properties_count = 0;
            $userSubscription->ref_property_id = $propertyID;
            $userSubscription->save();

            return response()->json([
                'success' => true,
                'message' => 'Subscription initiated',
                'data' => [
                    'email' => $email,
                    'amount' => $amount,
                ],
            ], 200,);
        }
    }

    public function finishPayment(Request $request)
    {
        try {
            $reference = $request['uniqueTransRef'];
            $userID = $request['user_id'];
            $subscription = $request['subscription_id'];
            $propertyID = $request['propertyID'];

            UserSubscription::where('user_subscriptions.user_id', $userID)
                ->where('user_subscriptions.is_active', 1)->update([
                    'is_active' => 0,

                ]);

            UserSubscription::where('paystack_reference_no', $reference)->update([
                'is_active' => 1,
                'updated_by' => $userID,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'trans_id' => $reference,
            ]);

            $refProperty = UserSubscription::where('paystack_reference_no', $reference)->first();

            if (!empty($refProperty)) {
                Property::where('id',  $refProperty->ref_property_id)->update([
                    'is_active' =>  PropertyStatuses::PENDING,
                    'updated_by' => $userID,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'prop_subscription_id' => UserSubscription::where('user_id', $userID)->where('is_active', 1)->first()->id,
                ]);

                $propertDetails = Property::getPropertyByID($refProperty->ref_property_id);

                if (!empty($propertDetails)) {

                    UserSubscription::where('user_subscriptions.user_id', $userID)
                        ->where('user_subscriptions.is_active', 1)->update([
                            'properties_count' => 1,
                        ]);

                    NotifyAdminsOfPostedProperty::dispatch($propertDetails->id);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment Made',
                'data' => ''
            ], 200,);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing payment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify Apple In-App Purchase
     */
    public function verifyApplePurchase(Request $request)
    {
        try {
            // Validate required fields
            $request->validate([
                'user_id' => 'required|integer',
                'subscription_id' => 'required|integer',
                'apple_receipt' => 'required|string',
                'transaction_id' => 'required|string',
                'product_id' => 'required|string',
                'propertyID' => 'nullable|integer'
            ]);

            $userID = $request->input('user_id');
            $subscriptionId = $request->input('subscription_id');
            $appleReceipt = $request->input('apple_receipt');
            $transactionId = $request->input('transaction_id');
            $productId = $request->input('product_id');
            $propertyID = $request->input('propertyID');

            // Map of product IDs to subscription IDs for validation
            $validProductIds = [
                'net.justapartments.app.bronze_monthly' => 1,
                'net.justapartments.app.silver_monthly' => 2,
                'net.justapartments.app.basic_monthly' => 3,
                'net.justapartments.app.gold_monthly' => 4,
                'net.justapartments.app.pro_monthly' => 5,
                'net.justapartments.app.millionaire_monthly' => 6,
            ];

            // Validate product ID
            if (!isset($validProductIds[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product ID'
                ], 400);
            }

            // Verify with Apple's servers
            $verificationResult = $this->verifyReceiptWithApple($appleReceipt);

            if (!$verificationResult['success']) {
                Log::error('Apple receipt verification failed', [
                    'user_id' => $userID,
                    'product_id' => $productId,
                    'error' => $verificationResult['message']
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $verificationResult['message']
                ], 400);
            }

            // Check if transaction was already processed
            $existingSubscription = UserSubscription::where('apple_transaction_id', $transactionId)->first();
            if ($existingSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction already processed'
                ], 400);
            }

            // Get subscription details
            $subscriptionDetails = Subscription::where('id', $subscriptionId)->first();
            if (!$subscriptionDetails) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid subscription'
                ], 400);
            }

            // Deactivate existing subscriptions
            UserSubscription::where('user_id', $userID)
                ->where('is_active', 1)
                ->update(['is_active' => 0]);

            // Create new subscription
            $userSubscription = new UserSubscription();
            $userSubscription->user_id = $userID;
            $userSubscription->subscription_id = $subscriptionId;
            $userSubscription->start_date = Carbon::now();
            $userSubscription->end_date = Carbon::now()->addDays(30);
            $userSubscription->is_active = 1;
            $userSubscription->created_by = $userID;
            $userSubscription->updated_by = $userID;
            $userSubscription->apple_transaction_id = $transactionId;
            $userSubscription->apple_product_id = $productId;
            $userSubscription->apple_receipt_data = $appleReceipt;
            $userSubscription->properties_count = ($propertyID != null && $propertyID > 0) ? 1 : 0;
            $userSubscription->ref_property_id = $propertyID;
            $userSubscription->save();

            // Update property if provided
            if ($propertyID != null && $propertyID > 0) {
                Property::where('id', $propertyID)->update([
                    'is_active' => PropertyStatuses::PENDING,
                    'updated_by' => $userID,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'prop_subscription_id' => $userSubscription->id,
                ]);

                // Notify admins
                NotifyAdminsOfPostedProperty::dispatch($propertyID);
            }

            Log::info('Apple purchase verified successfully', [
                'user_id' => $userID,
                'subscription_id' => $subscriptionId,
                'transaction_id' => $transactionId,
                'product_id' => $productId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Apple purchase verified successfully',
                'data' => [
                    'subscription_id' => $userSubscription->id,
                    'subscription_name' => $subscriptionDetails->sbscription_title,
                    'end_date' => $userSubscription->end_date
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Apple purchase verification error', [
                'error' => $e->getMessage(),
                'user_id' => $request->input('user_id'),
                'transaction_id' => $request->input('transaction_id')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify Apple purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify receipt with Apple's servers
     */
    private function verifyReceiptWithApple($receiptData)
    {
        try {
            // Apple's verification URL (use sandbox for testing)
            $verificationUrl = env('APPLE_SANDBOX_MODE', true)
                ? 'https://sandbox.itunes.apple.com/verifyReceipt'
                : 'https://buy.itunes.apple.com/verifyReceipt';

            $response = Http::timeout(30)->post($verificationUrl, [
                'receipt-data' => $receiptData,
                'password' => env('APPLE_SHARED_SECRET'), // Your App Store Connect shared secret
                'exclude-old-transactions' => true
            ]);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'Failed to connect to Apple verification service'
                ];
            }

            $responseData = $response->json();
            $status = $responseData['status'] ?? -1;

            // Handle different status codes
            switch ($status) {
                case 0:
                    return ['success' => true, 'data' => $responseData];
                case 21007:
                    // Receipt is from sandbox but sent to production
                    // Retry with sandbox URL
                    if (strpos($verificationUrl, 'sandbox') === false) {
                        return $this->verifyReceiptWithApple($receiptData, true);
                    }
                    break;
                case 21002:
                    return ['success' => false, 'message' => 'The data in the receipt-data property was malformed'];
                case 21003:
                    return ['success' => false, 'message' => 'The receipt could not be authenticated'];
                case 21004:
                    return ['success' => false, 'message' => 'The shared secret you provided does not match'];
                case 21005:
                    return ['success' => false, 'message' => 'The receipt server is not currently available'];
                case 21006:
                    return ['success' => false, 'message' => 'This receipt is valid but expired'];
                case 21008:
                    return ['success' => false, 'message' => 'This receipt is from the production environment'];
                default:
                    return ['success' => false, 'message' => 'Receipt verification failed with status: ' . $status];
            }

            return ['success' => false, 'message' => 'Unknown verification error'];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Receipt verification failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify Google Play Purchase (placeholder for future implementation)
     */
    public function verifyGooglePurchase(Request $request)
    {
        try {
            // Validate required fields
            $request->validate([
                'user_id' => 'required|integer',
                'subscription_id' => 'required|integer',
                'google_receipt' => 'required|string',
                'transaction_id' => 'required|string',
                'product_id' => 'required|string',
                'propertyID' => 'nullable|integer'
            ]);

            // TODO: Implement Google Play verification
            // This would involve verifying with Google Play Developer API

            return response()->json([
                'success' => false,
                'message' => 'Google Play verification not yet implemented'
            ], 501);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify Google purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
