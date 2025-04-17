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

                    // $propertDetails = Property::getPropertyByID($propertyID);

                    // Mail::send(
                    //     'mailing.admin.admins_notify',
                    //     [
                    //         'property_title' => $propertDetails->property_title,
                    //         'created_by_name' => $propertDetails->created_by_name,
                    //         'address' => $propertDetails->google_address,
                    //     ],
                    //     function ($message) use ($propertDetails, $request) {

                    //         $adminEmails = DB::table('model_has_roles')->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                    //             ->where('role_id', 1)
                    //             ->where('users.email', '!=', null)
                    //             ->pluck('users.email')
                    //             ->toArray();
                    //         $adminEmails[] = 'thejustgrouplimited@gmail.com';



                    //         $subject =  'POSTED ' . ": {$propertDetails->property_title} Requires Approval";
                    //         $message->from('app@justhomesapp.com', 'Just Homes');
                    //         $message->to($adminEmails);
                    //         //$message->to("kvnochieng52@gmail.com");
                    //         $message->subject($subject);
                    //     }
                    // );


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
}
