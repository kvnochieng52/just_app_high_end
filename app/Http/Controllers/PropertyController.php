<?php

namespace App\Http\Controllers;

use App\Models\LandMeasurement;
use App\Models\LandType;
use App\Models\LeaseType;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Paystack;
use App\Models\PhoneLead;
use App\Models\Property;
use App\Models\PropertyCondition;
use App\Models\PropertyFeature;
use App\Models\PropertyFeatureGroup;
use App\Models\PropertyFurnish;
use App\Models\PropertyImage;
use App\Models\PropertySelectedFeauture;
use App\Models\PropertyStatuses;
use App\Models\PropertySubType;
use App\Models\PropertyType;
use App\Models\SubRegion;
use App\Models\Subscription;
use App\Models\Town;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use OpenGraph;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class PropertyController extends Controller
{



    public function propertyDetails($propertyTypeSlug, $propertySlug)
    {
        $property = Property::getPropertyBySlug($propertySlug);
        $propertyImages = PropertyImage::getPropertyImages($property->id);
        $lightShowArray = $propertyImages->pluck('image')->toArray();







        if (!empty($property->video_link)) {
            $lightShowArray[] = $property->video_link;
        }


        if (Auth::check()) {
            Property::logPropertyLead(Auth::user()->id, $property->id);
        }



        return Inertia::render('Property/Details2', [
            'appUrl' => env('APP_URL'),
            'propertyDetails' => $property,
            'propertyImages' => $propertyImages,
            'lightShowImages' => $lightShowArray,
            'lightShowImageCount' => count($lightShowArray),
            'propertySelectedFeatures' => PropertySelectedFeauture::getPropertyFeatures($property->id),
            'metaDetails' => [
                'title' => $property->property_title,
                'description' => $property->property_description,
                'image_url' => env('APP_URL') . '/' . $property->thumbnail,
                'url' => env('APP_URL') . '/' . $property->property_type_slug . '/' . $property->slug
            ]
        ]);
    }


    public function post(Request $request)
    {




        return Inertia::render('Property/Post', [
            'towns' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['town_name AS text', 'id']),
        ]);
    }



    public function store(Request $request)
    {



        if ($request['step'] == 'new') {

            $this->validate($request, [
                'propertyTitle' => 'required',
                'propertyLocation' => 'required',
                'images' => 'required'
            ]);


            $images = $request['images'];



            $town = strtoupper($request['town']);
            $checkTown = Town::where('town_name', $town)->first();

            if (!empty($checkTown)) {
                $townID = $checkTown->id;
            } else {
                $townID = Town::insertGetId([
                    'town_name' => $town,
                    'is_active' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);
            }



            $subRegion = $request['subRegion'];
            $checkSubRegion = SubRegion::where('sub_region_name', $subRegion)->first();

            if (!empty($checkSubRegion)) {
                $SubRegionID = $checkSubRegion->id;
            } else {
                $SubRegionID = SubRegion::insertGetId([
                    'town_id' => $townID,
                    'sub_region_name' => $subRegion,
                    'is_active' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);
            }


            $randomNumber = rand(10000000, 99999999); // Generates an 8-digit random number
            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('propertyTitle')));



            $property = new Property();

            $property->property_title = $request['propertyTitle'];
            $property->slug = $slug . '-' . $randomNumber;
            $property->region_id = $SubRegionID;
            $property->town_id = $townID;
            $property->is_active = PropertyStatuses::DRAFT;
            $property->coordinates = $request['latitude'] . "," . $request['longitude'];
            $property->lat = $request['latitude'];
            $property->log = $request['longitude'];
            $property->country = $request['country'];
            $property->country_code = $request['countryCode'];
            $property->google_address = $request['address'];
            if (!empty($images) && count($images) > 0) {
                $property->thumbnail = $images[0];
            }
            $property->created_by = Auth::user()->id;
            $property->updated_by = Auth::user()->id;
            $property->save();


            if (!empty($images) && count($images) > 0) {
                foreach ($images as $image) {
                    PropertyImage::insert([
                        'property_id' => $property->id,
                        'image' => $image,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }

            return Inertia::location('/post-edit/2/' . $property->id);
        }





        if ($request['step'] == 1) {
            $this->validate($request, [
                'town' => 'required',
                'subRegion' => 'required',
                'propertyTitle' => 'required'
            ]);



            $propertyCodinates = Property::getCordinates($request['town'], $request['subRegion']);
            if ($propertyCodinates['success'] == true) {
                $latitude = $propertyCodinates['latitude'];
                $longitude = $propertyCodinates['longitude'];
                $coordinates = $propertyCodinates['coordinates'];
            } else {
                $latitude = '';
                $longitude = '';
                $coordinates = '';
            }

            Property::where('id', $request['propertyID'])->update([
                'property_title' => $request['propertyTitle'],
                'slug' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('propertyTitle'))),
                'region_id' => $request['subRegion'],
                'town_id' => $request['town'],
                'lat' => $latitude,
                'log' => $longitude,
                'coordinates' => $coordinates,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            // return redirect('/post-edit/2/' . $request['propertyID']);


            return Inertia::location('/post-edit/2/' . $request['propertyID']);
        }

        if ($request['step'] == 2) {




            $this->validate($request, [
                'propertType' => 'required',
                // 'propertyCondition' => 'required',
                // 'furnishStatus' => 'required',
                'leaseType' => 'required',
                'description' => 'required',
                'amount' => 'required',
                //'address' => 'required',
            ]);


            // dd(str_replace(',', '', $request['amount']));
            Property::where('id', $request['propertyID'])->update([
                'type_id' => $request['propertType'],
                'sub_property_type_id' => $request['propertSubType'],
                'condition_id' => $request['propertyCondition'],
                'furnish_id' =>  !empty($request['furnishStatus']) ? $request['furnishStatus'] : 1,
                'parking_spaces' => $request['parking'],
                'measurements' => $request['measurement'],
                'bedrooms' => $request['bedrooms'],
                'address' => $request['address'],
                'lease_type_id' => $request['leaseType'],
                'property_description' => $request['description'],
                'amount' => str_replace(',', '', $request['amount']),
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'on_auction' => $request['auction'],
                'on_offplan' => $request['offplan'],
                'land_type_id' => $request['landType'],
                'land_measurement_id' => $request['landMeasurement'],
                'land_measurement_name' => $request['landMeasurementName'],
            ]);

            // return redirect('/post-edit/3/' . $request['propertyID']);

            return Inertia::location('/post-edit/3/' . $request['propertyID']);
        }


        if ($request['step'] == 3) {

            $this->validate($request, [
                'listing' => 'required',
            ]);



            //dd("here");



            if (!empty($request['video'])) {

                $video_thumb = '';

                $video_url = self::getYouTubeEmbedUrl($request['video']);

                if ($video_url) {
                    // Fetch video details using YouTube oEmbed API
                    $oembed_url = "https://www.youtube.com/oembed?url=" . urlencode($video_url) . "&format=json";
                    $response = json_decode(file_get_contents($oembed_url), true);

                    if ($response) {
                        $video_thumb = $response['thumbnail_url'];
                    } else {
                        // dd("Failed to fetch video data.");
                    }
                } else {
                    // dd("Invalid YouTube URL.");
                }

                Property::where('id', $request['propertyID'])->update([
                    'video_link' => $request['video'],
                    'video_thumb' => $video_thumb,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            // Update selected features if provided
            if (!empty($request['selectedFeatures'])) {
                PropertySelectedFeauture::where('property_id', $request['propertyID'])->delete();
                foreach ($request['selectedFeatures'] as $feature) {
                    PropertySelectedFeauture::insert([
                        'property_id' => $request['propertyID'],
                        'group_id' => PropertyFeature::where('id', $feature)->first()->property_feature_group_id,
                        'feature_id' => $feature,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString(),
                    ]);
                }
            }



            //  dd($request['listing']);

            $companyLogoPath = null;

            // Conditionally update company details based on the listing type
            if (in_array($request['listing'], [2, 3])) { // 2 or 3 indicate agency/company listings
                // Check if a file is provided
                if ($request->hasFile('companyLogo')) {
                    $companyLogo = $request->file('companyLogo');

                    // Define the destination path
                    $destinationPath = public_path('company_logos');

                    // Create the directory if it doesn't exist
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    // Generate a unique file name
                    //  $fileName = time() . '_' . $companyLogo->getClientOriginalName();

                    $fileName = Str::random(30) . "." . $companyLogo->getClientOriginalExtension();

                    // Move the file to the public/company_logos directory
                    $companyLogo->move($destinationPath, $fileName);

                    // Set the path for saving in the database
                    $companyLogoPath = 'company_logos/' . $fileName;
                }

                // Update the Property model or handle company details
                // Example:
                // Property::where('id', $request->propertyID)->update(['company_logo' => $companyLogoPath]);
            }



            Property::where('id', $request['propertyID'])->update([
                'listing_as' => $request['listing'],
                'company_name' => $request['companyName'],
                'company_logo' => $companyLogoPath,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            // return redirect('/dashboard')->with('success', 'Property Successfully Posted.');

            return redirect('/post-edit/4/' . $request['propertyID']);

            //return Inertia::location('/post-edit/4/' . $request->propertyID);
        }


        if ($request['step'] == 4) {

            $subscription = $request['subscription'];

            if (!empty($subscription)) {

                if ($subscription == 1) {

                    $userSubscription = new UserSubscription();
                    $userSubscription->user_id = Auth::user()->id;
                    $userSubscription->start_date = Carbon::now();
                    $userSubscription->end_date = Carbon::now()->addDays(30);
                    $userSubscription->is_active = 1;
                    $userSubscription->created_by =  Auth::user()->id;
                    $userSubscription->updated_by =  Auth::user()->id;
                    $userSubscription->subscription_id = $subscription;
                    $userSubscription->properties_count = 1;
                    $userSubscription->ref_property_id = $request['propertyID'];
                    $userSubscription->save();


                    UserSubscription::where('user_id', Auth::user()->id)
                        ->where('is_active', 1)->update([
                            'properties_count' => 1,
                        ]);

                    Property::where('id', $request['propertyID'])->update(['is_active' => PropertyStatuses::PENDING]);


                    $propertDetails = Property::getPropertyByID($request['propertyID']);
                    Mail::send(
                        'mailing.admin.admins_notify',
                        [
                            'property_title' => $propertDetails->property_title,
                            'created_by_name' => $propertDetails->created_by_name,
                            'address' => $propertDetails->google_address,
                        ],
                        function ($message) use ($propertDetails, $request) {

                            $adminEmails = DB::table('model_has_roles')->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                                ->where('role_id', 1)
                                ->where('users.email', '!=', null)
                                ->pluck('users.email')
                                ->toArray();
                            $adminEmails[] = 'thejustgrouplimited@gmail.com';


                            $subject =  'POSTED ' . ": {$propertDetails->property_title} Requires Approval";
                            $message->from('app@justhomesapp.com', 'Just Homes');
                            $message->to($adminEmails);
                            // $message->to("kvnochieng52@gmail.com");
                            $message->subject($subject);
                        }
                    );

                    return  redirect('/dashboard/listing')->with('success', 'Property Successfully Posted.');
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
                    $userSubscription->properties_count = 1;
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
            } else {

                $userActiveSubscription = UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
                    ->where('user_subscriptions.user_id', Auth::user()->id)
                    ->where('user_subscriptions.is_active', 1)
                    ->first();




                if (!empty($userActiveSubscription)) {

                    $incomingCount = $userActiveSubscription->properties_count + 1;

                    if ($incomingCount <= $userActiveSubscription->properties_post_count || $userActiveSubscription->properties_post_count == -1) {

                        UserSubscription::where('user_id', Auth::user()->id)
                            ->where('is_active', 1)->update([
                                'properties_count' => $userActiveSubscription->properties_count + 1,
                            ]);

                        Property::where('id', $request['propertyID'])->update(['is_active' => PropertyStatuses::PENDING]);

                        $propertDetails = Property::getPropertyByID($request['propertyID']);
                        Mail::send(
                            'mailing.admin.admins_notify',
                            [
                                'property_title' => $propertDetails->property_title,
                                'created_by_name' => $propertDetails->created_by_name,
                                'address' => $propertDetails->google_address,
                            ],
                            function ($message) use ($propertDetails, $request) {

                                $adminEmails = DB::table('model_has_roles')->leftJoin('users', 'model_has_roles.model_id', 'users.id')
                                    ->where('role_id', 1)
                                    ->where('users.email', '!=', null)
                                    ->pluck('users.email')
                                    ->toArray();
                                $adminEmails[] = 'thejustgrouplimited@gmail.com';



                                $subject =  'POSTED ' . ": {$propertDetails->property_title} Requires Approval";
                                $message->from('app@justhomesapp.com', 'Just Homes');
                                $message->to($adminEmails);
                                //$message->to("kvnochieng52@gmail.com");
                                $message->subject($subject);
                            }
                        );

                        return redirect('/dashboard/listing')->with('success', 'Property Successfully Posted.');
                    } else {
                        return redirect('/dashboard/listing')->with('error', 'You Have Exhausted Subscription. Please renew and try again');
                    }
                } else {
                    return redirect('/dashboard/listing')->with('error', 'You Dont have an active Subscription. Please renew and try again');
                }
            }
        }
    }


    public static function getYouTubeEmbedUrl($video_url)
    {
        // Parse the URL
        $parsed_url = parse_url($video_url);

        if (isset($parsed_url['host']) && ($parsed_url['host'] == 'youtu.be')) {
            // Short URL format (youtu.be)
            $video_id = ltrim($parsed_url['path'], '/');
        } elseif (isset($parsed_url['query'])) {
            // Normal YouTube URL format (youtube.com/watch?v=VIDEO_ID)
            parse_str($parsed_url['query'], $query_params);
            $video_id = $query_params['v'] ?? null;
        }

        if (!empty($video_id)) {
            return "https://www.youtube.com/watch?v=" . $video_id;
        }

        return null;
    }

    public function postEdit($step, $id)
    {

        if ($step == 1) {
            $property = Property::find($id);
            return Inertia::render('Property/PostEditBasic', [
                'property' => $property,
                'defaultSubRegion' => SubRegion::where('id', $property->region_id)->first(['sub_region_name AS text', 'id']),
                'towns' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['town_name AS text', 'id']),
            ]);
        }


        if ($step == 2) {

            return Inertia::render('Property/PostEdit', [
                'property' => Property::find($id),
                'propertyTypes' => PropertyType::where('property_type_is_active', 1)->orderBy('order', 'ASC')->get(['property_type_name AS text', 'id']),
                'propertyConditions' => PropertyCondition::where('is_active', 1)->orderBy('order', 'ASC')->get(['condition_name AS text', 'id']),
                'furnishStatuses' => PropertyFurnish::where('is_active', 1)->orderBy('order', 'ASC')->get(['furnish_name AS text', 'id']),
                'leaseTypes' => LeaseType::where('is_active', 1)->orderBy('order', 'ASC')->get(['lease_type_name AS text', 'id']),
                'listings' => Listing::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'listing_name as value']),
                'landTypes' => LandType::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'land_type_name as value']),
                'landMeasurements' => LandMeasurement::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'measurement_name as value']),

            ]);
        }

        if ($step == 3) {



            return Inertia::render('Property/PostEditFinal', [
                'featureGroups' => PropertyFeature::propertyFeatures(),
                'property' => Property::find($id),
                'propertyFeatures' => PropertySelectedFeauture::where("property_id", $id)->pluck('feature_id')->toArray(),
                'listings' => Listing::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'listing_name as value']),
                'userDetails' => User::where('id', Auth::user()->id)->first(),
            ]);
        }



        if ($step == 4) {




            return Inertia::render('Property/Subscription', [
                'featureGroups' => PropertyFeature::propertyFeatures(),
                'property' => Property::find($id),
                'propertyFeatures' => PropertySelectedFeauture::where("property_id", $id)->pluck('feature_id')->toArray(),
                'listings' => Listing::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'listing_name as value']),
                'userDetails' => User::where('id', Auth::user()->id)->first(),

                'subscriptions' => Subscription::where('is_active', 1)->orderBy('order_by', 'ASC')->get(),





                'userActiveSubscription' => UserSubscription::leftJoin('subscriptions', 'user_subscriptions.subscription_id', '=', 'subscriptions.id')
                    ->where('user_subscriptions.user_id', Auth::user()->id)
                    ->where('user_subscriptions.is_active', 1)
                    ->first(),

                'defaultSubscription' => Subscription::where('id', 1)->first(),

            ]);
        }
    }



    public function fetchSubLocations($townId)
    {

        $subRegions = SubRegion::where('town_id', $townId)
            ->where('is_active', 1)
            ->orderBy('order', 'ASC')
            ->get(['sub_region_name AS text', 'id']);
        return response()->json([
            'success' => true,
            'data' => $subRegions
        ], 200);
    }



    public function fetchSubProperties($type_id)
    {

        $subRegions = PropertySubType::where('property_type_id', $type_id)
            ->where('is_active', 1)
            // ->orderBy('order', 'ASC')
            ->get(['property_sub_type_name AS text', 'id']);
        return response()->json([
            'success' => true,
            'data' => $subRegions
        ], 200);
    }




    public function uploadImages(Request $request)
    {

        if ($request->hasFile('imageFilepond')) {
            return $request->file('imageFilepond')->store('uploads/images', 'public');
        }

        return 'no';
    }


    protected function processImage($image)
    {
        if ($image) {
            $path = storage_path('app/public/' . $image);
            if (file_exists($path)) {
                copy($path, public_path($image));
                unlink($path);
            }
        }
    }

    public function postDelete($id)
    {


        Property::where('id', $id)->delete();
        return redirect('/dashboard')->with('success', 'Property Deleted.');
    }


    public function propertiesByType($propertyTypeSlug)
    {
        return Inertia::render('Property/TypeDetails', [
            'propertyTypeSlug' => $propertyTypeSlug,
            'propertyTypeDetails' => PropertyType::where('property_type_slug', $propertyTypeSlug)->first(),
        ]);
    }



    public function storeLead(Request $request)
    {

        PhoneLead::insert([
            'property_id' => $request['propertyID'],
            'user_id' => $request['userID'],
            'date' => Carbon::now()->toDateTimeString(),
        ]);
        return response()->json([
            "success" => true,
        ]);
    }



    public function sendMessage(Request $request)
    {

        Message::insert([
            'name' => $request['name'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'message' => $request['message'],
            'user_id' => $request['userID'],
            'property_id' => $request['propertyID'],
            'date' => Carbon::now()->toDateTimeString(),
        ]);
        return response()->json([
            "success" => true,
        ]);
    }



    public function updateCordinates(Request $request)
    {

        $properties = Property::where('is_active', 1)->get();

        $updated = 0;

        foreach ($properties as $property) {

            if (!empty($property->town_id) && !empty($property->region_id)) {

                $propertyCodinates = Property::getCordinates($property->town_id, $property->region_id, $property->id);
                if ($propertyCodinates['success'] == true) {
                    $latitude = $propertyCodinates['latitude'];
                    $longitude = $propertyCodinates['longitude'];
                    $coordinates = $propertyCodinates['coordinates'];

                    Property::where('id', $property->id)->update([
                        'log' => $longitude,
                        'lat' => $latitude,
                        'coordinates' => $coordinates,
                    ]);

                    $updated = $updated + 1;
                }
            }
        }

        echo "Records Updated " . $updated;
    }




    public function uploadDropZoneImages(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif', // Add file validation
        ]);

        // Check if a file was uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Generate a unique file name
            $fileName = Str::random(30) . "." . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/images'); // Path to the public/uploads folder

            // Move the file to the destination path
            $file->move($destinationPath, $fileName);

            // Return a success response with the relative file path
            return response()->json([
                'message' => 'File uploaded successfully',
                'imagePath' => 'uploads/images/' . $fileName, // Return the relative path
            ]);
        }

        // If no file was uploaded
        return response()->json([
            'message' => 'No file uploaded',
        ], 400);
    }


    public function checkoutNow($subscription, $price)
    {
        return Inertia::render('Property/Checkout', [
            'subscription' => $subscription,
            'price' => $price

            // 'property' => $property,
            // 'defaultSubRegion' => SubRegion::where('id', $property->region_id)->first(['sub_region_name AS text', 'id']),
            // 'towns' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['town_name AS text', 'id']),
        ]);
    }



    public function checkoutConfirmation(Request $request)
    {
        return Inertia::render('Property/CheckoutConfirm', []);
    }
}
