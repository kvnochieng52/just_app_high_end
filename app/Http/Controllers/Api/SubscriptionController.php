<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

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
                'userActiveSubscription' => $userActiveSubscription
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
}
