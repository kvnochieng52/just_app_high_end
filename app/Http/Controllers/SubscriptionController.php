<?php

namespace App\Http\Controllers;

use App\Models\Paystack;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function renew(Request $request)
    {
        return Inertia::render('Subscription/Renew', [
            'subscriptions' => Subscription::where('is_active', 1)->get(),
            'userActiveSubscription' => UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
                ->where('user_id', Auth::user()->id)
                ->where('user_subscriptions.is_active', 1)
                ->orderBy('user_subscriptions.id', 'DESC')
                ->first(),
        ]);
    }


    public function renewProcess(Request $request)
    {
        $this->validate($request, [
            'subscription' => 'required',
        ]);



        $subscription = $request['subscription'];
        if (!empty($subscription)) {

            if ($subscription == 1) {


                UserSubscription::where('user_id', Auth::user()->id)
                    ->where('is_active', 1)->update([
                        'is_active' => 0,
                    ]);

                $userSubscription = new UserSubscription();
                $userSubscription->user_id = Auth::user()->id;
                $userSubscription->start_date = Carbon::now();
                $userSubscription->end_date = Carbon::now()->addDays(30);
                $userSubscription->is_active = 1;
                $userSubscription->created_by =  Auth::user()->id;
                $userSubscription->updated_by =  Auth::user()->id;
                $userSubscription->subscription_id = $subscription;
                $userSubscription->properties_count = 0;
                $userSubscription->ref_property_id = $request['propertyID'];
                $userSubscription->save();

                return  redirect('/dashboard')->with('success', 'Your Subscription Renewed successfully');
            } else {

                $subscriptionDetails = Subscription::where('id', $subscription)->first();

                $email = Auth::user()->email;
                $amount = $subscriptionDetails->amount;

                $results = Paystack::initiatePayment($email, $amount);

                $userSubscription = new UserSubscription();
                $userSubscription->user_id = Auth::user()->id;
                $userSubscription->start_date = Carbon::now();
                $userSubscription->end_date = Carbon::now()->addDays(30);
                $userSubscription->is_active = 0;
                $userSubscription->created_by =  Auth::user()->id;
                $userSubscription->updated_by =  Auth::user()->id;
                $userSubscription->subscription_id = $subscription;
                $userSubscription->paystack_reference_no = $results["data"]["reference"];
                $userSubscription->properties_count = 0;
                $userSubscription->ref_property_id = $request['propertyID'];
                $userSubscription->save();

                if ($results["status"]) {
                    return Inertia::location($results["data"]["authorization_url"]);
                } else {
                    return response()->json([
                        "error" => "Payment initialization failed: " . $results["message"]
                    ], 400);
                }
            }
        }
    }


    public function status()
    {
        $user = Auth::user();

        $subscription = UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
            ->select(
                'subscriptions.sbscription_title',
                'user_subscriptions.properties_count',
                'subscriptions.properties_post_count',
                'user_subscriptions.end_date'
            )
            ->where('user_subscriptions.user_id', $user->id)
            ->where('user_subscriptions.is_active', 1)
            ->orderBy('user_subscriptions.id', 'DESC')
            ->first();

        return response()->json([
            'subscription' => $subscription,
        ]);
    }
}
