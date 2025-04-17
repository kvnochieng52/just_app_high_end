<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PropertyController as ControllersPropertyController;
use App\Models\Favorite;
use App\Models\LandMeasurement;
use App\Models\LandType;
use App\Models\LeaseType;
use App\Models\Listing;
use App\Models\Property;
use App\Models\PropertyCondition;
use App\Models\PropertyFeature;
use App\Models\PropertyFurnish;
use App\Models\PropertyImage;
use App\Models\PropertySelectedFeauture;
use App\Models\PropertyType;
use App\Models\SubRegion;
use App\Models\Town;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use OpenGraph;
use App\Models\Message;
use App\Models\PhoneLead;
use App\Models\PropertyStatuses;
use App\Models\ReportIssueReason;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Break_;

class PropertyController extends Controller
{
    public function getInitDataPartOne(Request $request)
    {
        return response()->json([
            "success" => true,
            "data" => [
                'userFinishedProfile' => User::checkUserProfile($request['user_id']),
                'townsList' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'town_name as value']),
                'subRegions' => SubRegion::where(['is_active' => 1])->orderBy('order', 'ASC')->get(['sub_region_name AS value', 'id', 'town_id']),
                'PropertyTypesList' => PropertyType::where('property_type_is_active', 1)->orderBy('order', 'ASC')->get(['id', 'property_type_name as value']),
                'propertyConditionsList' => PropertyCondition::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'condition_name as value']),
                'furnishedList' => PropertyFurnish::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'furnish_name as value']),
                'leaseTypesList' => LeaseType::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'lease_type_name as value']),
                'propertyFeaturesList' => PropertyFeature::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'feature_name']),
                'propertyDetails' => !empty($request['propertyID']) ?  Property::getPropertyByID($request['propertyID']) : [],
                'PropertyTypesByNameList' => PropertyType::where('property_type_is_active', 1)->orderBy('order', 'ASC')->pluck('property_type_name')->toArray(),
                'propertyConditionByNameList' => PropertyCondition::where('is_active', 1)->orderBy('order', 'ASC')->pluck('condition_name')->toArray(),
                'furnishedByNameList' => PropertyFurnish::where('is_active', 1)->orderBy('order', 'ASC')->pluck('furnish_name')->toArray(),
                'landTypes' => LandType::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'land_type_name as value']),
                'landMeasurements' => LandMeasurement::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'measurement_name as value']),
                'listings' => Listing::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'listing_name as value']),
                'userDetails' => User::find($request['user_id']),
                //test
            ],
        ]);
    }

    public function getPropertyByID(Request $request)
    {
        return response()->json([
            "success" => true,
            "data" => [
                'propertyDetails' => Property::getPropertyByID($request['propertyID'])
            ],

        ]);
    }


    public function getSubRegions(Request $request)
    {
        return response()->json([
            "success" => true,
            "data" => [
                'subRegionsList' => SubRegion::where([
                    'town_id' => $request['townID'],
                    'is_active' => 1
                ])->orderBy('order', 'ASC')->get([
                    'id',
                    'sub_region_name as value'
                ]),
            ],

        ]);
    }



    public function getSubRegionsPost(Request $request)
    {




        if ($request['propertyID'] == 0) {
            $propertyID = Property::insertGetId([
                'created_by' => $request['user_id'],
                'updated_by' => $request['user_id'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        } else {
            $propertyID =  $request['propertyID'];
        }


        return response()->json([
            "success" => true,
            "data" => [
                'subRegionsList' => SubRegion::where([
                    'town_id' => $request['townID'],
                    'is_active' => 1
                ])->orderBy('order', 'ASC')->get([
                    'id',
                    'sub_region_name as value'
                ]),

                'propertyID' => $propertyID,
                'propertyDetails' => !empty($request['propertyID']) ?  Property::getPropertyByID($request['propertyID']) : [],
                'propertyFeaturesList' => PropertyFeature::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'feature_name']),
            ],

        ]);
    }





    public function post(Request $request)
    {
        $step = $request['step'];
        switch ($step) {
            case "1":

                try {

                    $validator = Validator::make($request->all(), [
                        'step' => 'required',
                        'propertyTitle' => 'required|string',
                        'town' => 'required',
                        'subRegion' => 'required',
                        'images' => 'required',
                        'latitude'      => 'required',
                        'longitude'     => 'required',
                        'country'       => 'required|string',
                        'countryCode'   => 'required|string',
                        'address'       => 'required|string',
                        'user_id'       => 'required|integer',
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Validation errors',
                            'errors'  => $validator->errors()
                        ], 422);
                    }

                    $images = $request->input('images'); // e.g., "image1.jpg,image2.jpg,image3.jpg"
                    $imagesArray = explode(',', $images);

                    // Process town
                    $town = strtoupper($request->input('town'));
                    $checkTown = Town::where('town_name', $town)->first();

                    if ($checkTown) {
                        $townID = $checkTown->id;
                    } else {
                        $townID = Town::insertGetId([
                            'town_name' => $town,
                            'is_active' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }

                    // Process sub-region
                    $subRegion = $request->input('subRegion');
                    $checkSubRegion = SubRegion::where('sub_region_name', $subRegion)->first();

                    if ($checkSubRegion) {
                        $SubRegionID = $checkSubRegion->id;
                    } else {
                        $SubRegionID = SubRegion::insertGetId([
                            'town_id' => $townID,
                            'sub_region_name' => $subRegion,
                            'is_active' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }


                    $randomNumber = rand(10000000, 99999999); // Generates an 8-digit random number
                    $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('propertyTitle')));

                    // Create property
                    $property = new Property();
                    $property->property_title = $request->input('propertyTitle');
                    //$property->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('propertyTitle')));
                    $property->slug = $slug . '-' . $randomNumber;
                    $property->region_id = $SubRegionID;
                    $property->town_id = $townID;
                    $property->coordinates = $request->input('latitude') . "," . $request->input('longitude');
                    $property->lat = $request->input('latitude');
                    $property->log = $request->input('longitude');
                    $property->country = $request->input('country');
                    $property->is_active = PropertyStatuses::DRAFT;
                    $property->country_code = $request->input('countryCode');
                    $property->google_address = $request->input('address');
                    $property->thumbnail = !empty($imagesArray) ? $imagesArray[0] : null;
                    $property->created_by = $request->input('user_id');
                    $property->updated_by = $request->input('user_id');
                    $property->save();



                    // Insert property images if available
                    if (!empty($imagesArray)) {
                        foreach ($imagesArray as $image) {
                            PropertyImage::insert([
                                'property_id' => $property->id,
                                'image' => $image,
                                'created_by' => $request->input('user_id'),
                                'updated_by' => $request->input('user_id'),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }

                    return response()->json([
                        "success" => true,
                        "data" => ["propertyID" => $property->id,]
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        "success" => false,
                        "message" => "An error occurred while processing the request.",
                        "error" => $e->getMessage()
                    ], 500);
                }

                break;
            case "2":
                Property::where('id', $request['propertyID'])->update([
                    'type_id' => $request['propertyType'],
                    'condition_id' => $request['propertyCondition'] !== 'null' ? $request['propertyCondition'] : null,
                    'furnish_id' => $request['furnished'] !== 'null' ? $request['furnished'] : null,
                    'parking_spaces' => $request['parking'] !== 'null' ? $request['parking'] : null,
                    'measurements' => $request['measurement'] !== 'null' ? $request['measurement'] : null,
                    'bedrooms' => $request['bedrooms'] !== 'null' ? $request['bedrooms'] : null,
                    'address' => $request['address'],
                    'lease_type_id' => $request['leaseType'],
                    'property_description' => $request['description'],
                    'amount' => $request['amount'],
                    'updated_by' => $request['userID'],
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'on_auction' => $request['auction'],
                    'on_offplan' => $request['offplan'],
                    'land_type_id' => $request['landType'],
                    'land_measurement_id' => $request['landMeasurementID'] !== 'null' ? $request['landMeasurementID'] : null,
                    'land_measurement_name' => $request['landMeasurementName'] !== 'null' ? $request['landMeasurementName'] : null,
                ]);

                return response()->json([
                    "success" => true,
                    'data' => ['propertyID' => $request['propertyID'],],
                ]);
                break;

            case "3":



                if (!empty($request['youtubeLink'])) {

                    //  $video_data = OpenGraph::fetch($request['youtubeLink']);


                    $video_thumb = '';

                    $video_url = ControllersPropertyController::getYouTubeEmbedUrl($request['video']);

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
                        'video_link' => $request['youtubeLink'],
                        'video_thumb' =>  $video_thumb,
                        'updated_by' => $request['userID'],
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                }


                // Log all request data to verify structure
                // Log all request data to verify structure
                // dd($request->all());

                if (!empty($request['selectedFeatures'])) {
                    // Check if selectedFeatures is a JSON string and decode it
                    $selectedFeatures = $request['selectedFeatures'];
                    if (is_string($selectedFeatures)) {
                        $selectedFeatures = json_decode($selectedFeatures, true);
                    }

                    // Check if selectedFeatures is now an array
                    if (is_array($selectedFeatures)) {
                        PropertySelectedFeauture::where('property_id', $request['propertyID'])->delete();
                        foreach ($selectedFeatures as $feature) {
                            if (isset($feature['checked']) && $feature['checked']) {
                                PropertySelectedFeauture::insert([
                                    'property_id' => $request['propertyID'],
                                    'group_id' => PropertyFeature::where('id', $feature['id'])->first()->property_feature_group_id,
                                    'feature_id' => $feature['id'],
                                    'created_by' => $request['userID'],
                                    'updated_by' => $request['userID'],
                                    'created_at' => Carbon::now()->toDateTimeString(),
                                    'updated_at' => Carbon::now()->toDateTimeString()
                                ]);
                            }
                        }
                    } else {
                        // Handle the error if selectedFeatures is not an array
                        return response()->json(['error' => 'Invalid selectedFeatures data'], 400);
                    }
                }


                $propertyDetails = Property::where('id', $request['propertyID'])->first();


                $updateArray = [
                    'company_name' => $request['companyName'],
                    'listing_as' => $request['listingAs'],
                    'updated_by' => $request['userID'],
                    'updated_at' => Carbon::now()->toDateTimeString()
                ];

                if ($propertyDetails->prop_subscription_id == null) {
                    $updateArray['is_active'] = PropertyStatuses::DRAFT;
                }

                if ($request['companyLogoChanged'] == false) {
                    $updateArray['company_logo'] = User::where('id', $request['userID'])->first()->company_logo;
                }

                Property::where('id', $request['propertyID'])->update($updateArray);

                return response()->json([
                    "success" => true,
                    'data' => ['propertyID' => $request['propertyID'],],
                ]);

                break;

            case "4":

                // Property::where('id', $request['propertyID'])->update([
                //     'property_title' => $request['title'],
                //     'slug' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title'))),
                //     'region_id' => $request['region'],
                //     'town_id' => $request['town'],
                //     'updated_at' => Carbon::now()->toDateTimeString(),
                //     'updated_by' => $request['userID'],
                // ]);
                $property =  Property::find($request['propertyID']);


                $propertyCodinates = Property::getCordinates($request['town'], $request['region']);

                if ($propertyCodinates['success'] == true) {
                    $property->lat = $propertyCodinates['latitude'];
                    $property->log = $propertyCodinates['longitude'];
                    $property->coordinates = $propertyCodinates['coordinates'];
                }

                $property->property_title = $request['title'];
                $property->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title')));
                $property->region_id = $request['region'];
                $property->town_id = $request['town'];
                $property->updated_at = Carbon::now()->toDateTimeString();
                $property->updated_by = $request['user_id'];
                $property->save();

                $filePaths = [];

                if (!empty($request->file('images'))) {
                    $uploadedFiles = $request->file('images');
                    foreach ($uploadedFiles as $file) {
                        // Move the file to the /public directory
                        $fileName = Str::random(30) . "." . $file->getClientOriginalExtension();
                        $path = $file->move(public_path('uploads/images'), $fileName);

                        //$filePaths[] = asset('images/' . $file->getClientOriginalName());
                        $filePaths[] = "uploads/images/" . $fileName;
                    }
                }

                if (!empty($filePaths)) {
                    $property->thumbnail = $filePaths[0];
                    $property->save();
                    foreach ($filePaths as $image) {
                        PropertyImage::insert([
                            'property_id' => $property->id,
                            'image' => $image,
                            'created_by' => $request['user_id'],
                            'updated_by' => $request['user_id'],
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);
                    }
                }
                return response()->json([
                    "success" => true,
                    'data' => ['propertyID' => $property->id,],
                ]);
                break;

            case "5":

                //Here

                // $userID=$request['user_id'];
                // $propertyID=$request['propertyID'];
                // $slectedSubscription=



                break;
        }
    }


    public function details(Request $request)
    {

        $propertyDetails = Property::getPropertyByID($request['propertyID']);

        if (!empty($request['user_id'])) {
            Property::logPropertyLead($request['user_id'], $request['propertyID']);
        }

        return response()->json([
            "success" => true,
            "data" => [
                'propertyDetails' => $propertyDetails,
                'propertyImages' => PropertyImage::getPropertyImages($request['propertyID']),
                'propertyFaetures' => PropertySelectedFeauture::where('property_id', $request['propertyID'])
                    ->leftJoin('property_features', 'property_selected_feautures.feature_id', 'property_features.id')
                    ->get([
                        // 'property_selected_feautures.id',
                        'property_features.feature_name'
                    ]),
                'similarProperties' => Property::getSimilarProperties(6, $propertyDetails->created_by, $request['propertyID']),
                'reportIssueReasonsList' => ReportIssueReason::where('is_active', 1)->get(['id',  'issue_reason_name as value'])
            ],
        ]);
    }
    //t


    public function dashboadInitData(Request $request)
    {
        return response()->json([
            "success" => true,
            "data" => [
                'latestProperties' => Property::getLatestProperties(20),

            ],
        ]);
    }


    public function search(Request $request)
    {

        $propertyType = $request['propertyType'];
        $location = $request['location'];
        $townID = $request['townID'];
        $subRegionId = $request['subRegionId'];
        $condition = $request['propertyCondition'];
        $furnishType = $request['furnished'];
        $leaseType = $request['leaseType'];
        $bedroom = $request['bedroom'];
        $minPrice = $request['minPrice'];
        $maxPrice = $request['maxPrice'];
        $parking = $request['parking'];
        $auction = $request['auction'];
        $offplan = $request['offplan'];
        $governmentHousing = $request['governmentHousing'];





        $query = Property::propertiesQuery();
        $data = $query;




        if (!empty($townID)) {
            $data->where('properties.town_id', $townID);
        }


        if (!empty($subRegionId)) {
            $data->where('properties.region_id', $subRegionId);
        }

        if (!empty($location)) {

            $data->where(function ($query) use ($location) {
                $query->where('sub_region_name', 'like', '%' . $location . '%')
                    ->orWhere('town_name', 'like', '%' . $location . '%')
                    ->orWhere('address', 'like', '%' . $location . '%');
            });
        }

        if (!empty($leaseType)) {
            $data->where('lease_type_id', $leaseType);
        }



        if (!empty($propertyType)) {
            $data->where('type_id', $propertyType);
        }

        if (
            !empty($minPrice) &&
            !empty($maxPrice)
        ) {
            $data->where(function ($query) use ($minPrice, $maxPrice) {
                $query->where('amount', '>=', $minPrice)
                    ->where('amount', '<=', $maxPrice);
            });
        }

        if (!empty($condition)) {
            $data->where('condition_id', $condition);
        }

        if (!empty($bedroom)) {
            $data->where('bedrooms', $bedroom);
        }

        if (!empty($parking)) {
            $data->where('parking_spaces', $parking);
        }

        if (!empty($furnishType)) {
            $data->where('furnish_id', $furnishType);
        }

        if (!empty($offplan) && $offplan == 1) {
            $data->where('on_offplan', $offplan);
        }


        if (!empty($auction) && $auction == 1) {
            $data->where('on_auction', $auction);
        }

        if (!empty($request['governmentHousing'])) {
            $data->where('government_house', ' 1');
        }


        $data->where('properties.is_active', PropertyStatuses::PUBLISHED);

        $properties = $data->get();

        return response()->json([
            "success" => true,
            "data" => [
                'properties' => $properties,
                'searchParameters' => [
                    'propertyType' => $request['propertyType'],
                    'location' => $request['location'],
                    'condition' => $request['propertyCondition'],
                    'furnishType' => $request['furnished'],
                    'leaseType' => $request['leaseType'],
                    'bedroom' => $request['bedroom'],
                    'minPrice' => $request['minPrice'],
                    'maxPrice' => $request['maxPrice'],
                    'parking' => $request['parking'],
                ],
            ],
        ]);
    }




    public function searchAdvanced(Request $request)
    {

        $propertyType = $request['propertyType'];
        $location = $request['location'];
        $townID = $request['townID'];
        $subRegionId = $request['subRegionId'];
        $condition = $request['propertyCondition'];
        $furnishType = $request['furnished'];
        $leaseType = $request['leaseType'];
        $bedroom = $request['bedroom'];
        $minPrice = $request['minPrice'];
        $maxPrice = $request['maxPrice'];
        $parking = $request['parking'];
        $auction = $request['auction'];
        $offplan = $request['offplan'];

        $query = Property::propertiesQuery();
        $data = $query;




        if (!empty($townID)) {
            $data->where('properties.town_id', $townID);
        }


        if (!empty($subRegionId)) {
            $data->where('properties.region_id', $subRegionId);
        }


        if (!empty($location)) {
            $data->where(function ($query) use ($location) {
                $query->whereRaw('LOWER(sub_region_name) LIKE ?', ['%' . strtolower($location) . '%'])
                    ->orWhereRaw('LOWER(town_name) LIKE ?', ['%' . strtolower($location) . '%']);
                //->orWhereRaw('LOWER(address) LIKE ?', ['%' . strtolower($location) . '%']);
            });
        }

        if (!empty($leaseType)) {
            $data->where('lease_type_id', $leaseType);
        }



        if (!empty($propertyType)) {
            //$data->where('type_id', $propertyType);
            $data->whereIn('property_type_name', $propertyType);
        }

        if (
            !empty($minPrice) &&
            !empty($maxPrice)
        ) {
            $data->where(function ($query) use ($minPrice, $maxPrice) {
                $query->where('amount', '>=', $minPrice)
                    ->where('amount', '<=', $maxPrice);
            });
        }

        if (!empty($condition)) {
            // $data->where('condition_id', $condition);
            $data->whereIn('condition_name', $condition);
        }

        if (!empty($bedroom)) {
            $data->whereIn('bedrooms', $bedroom);
        }

        if (!empty($parking)) {
            $data->where('parking_spaces', $parking);
        }

        if (!empty($offplan) && $offplan == 1) {
            $data->where('on_offplan', $offplan);
        }


        if (!empty($auction) && $auction == 1) {
            $data->where('on_auction', $auction);
        }

        if (!empty($furnishType)) {
            $data->whereIn('furnish_name', $furnishType);
        }


        $data->where('properties.is_active', 1);
        $data->orderBy('properties.id', 'DESC');

        $properties = $data->get();

        return response()->json([
            "success" => true,
            "data" => [
                'properties' => $properties,
                'searchParameters' => [
                    'propertyType' => $request['propertyType'],
                    'location' => $request['location'],
                    'condition' => $request['propertyCondition'],
                    'furnishType' => $request['furnished'],
                    'leaseType' => $request['leaseType'],
                    'bedroom' => $request['bedroom'],
                    'minPrice' => $request['minPrice'],
                    'maxPrice' => $request['maxPrice'],
                    'parking' => $request['parking'],
                ],
            ],
        ]);
    }


    public function contactAgent(Request $request)
    {



        $propertyDetails = Property::getPropertyByID($request['propertyID']);
        return response()->json([
            "success" => true,
            "data" =>
            $propertyDetails,
            "message" => 'Email Sent Successfully'
        ]);

        if (!empty($propertyDetails)) {
            Mail::send('mailing.agent_email', [
                'property_title' => $propertyDetails->property_title,
                'name' => $request['name'],
                'email' => $request['email'],
                'telephone' => $request['telephone'],
                'userMessage' =>  $request['message']
            ], function ($message) use ($request, $propertyDetails) {
                $message->from('app@justhomesapp.com');
                $message->to($propertyDetails->email)->subject("Message from Just Home: " . $propertyDetails->property_title);
            });

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => 'Email Sent Successfully'
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => 'Email Not Sent. Please try again Later'
            ]);
        }
    }



    public function getUserProperties(Request $request)
    {

        return response()->json([
            "success" => true,
            "data" => [
                'properties' => Property::getUserProperties($request['user_id']),
                'userDetails' => User::find($request['user_id']),

            ],
        ]);
    }


    public function deleteProperty(Request $request)
    {
        Property::where('id', $request['property_id'])->delete();

        return response()->json([
            "success" => true,
            "message" => 'Property successfully deleted!'
        ]);
    }


    public function getLeads(Request $request)
    {
        Property::where('id', $request['property_id'])->delete();

        return response()->json([
            "success" => true,
            "message" => 'Property successfully deleted!',
            "data" => [
                'telephoneLeadsCount' => PhoneLead::where('user_id', $request['user_id'])->count(),
                'messagesCount' => Message::where('user_id', $request['user_id'])->count(),
                'appartmentsCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 1)->count(),
                'housesCount' => Property::where('created_by', $request['user_id'])->where('type_id', 2)->count(),
                'officeCount' => Property::where('created_by', $request['user_id'])->where('type_id', 3)->count(),
                'landsCount' => Property::where('created_by', $request['user_id'])->where('type_id', 7)->count(),
                'townHousesCount' => Property::where('created_by', $request['user_id'])->where('type_id', 5)->count(),
                'shopsCount' => Property::where('created_by', $request['user_id'])->where('type_id', 6)->count(),
                'villasCount' => Property::where('created_by', $request['user_id'])->where('type_id', 4)->count(),
                'recentMessages' => Message::leftJoin('properties', 'messages.property_id', 'properties.id')
                    ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
                    ->where('messages.user_id', $request['user_id'])
                    ->take(10)
                    ->orderBy('id', 'DESC')
                    ->get([
                        'messages.*',
                        'properties.property_title',
                        'property_types.property_type_name',
                    ])
            ]
        ]);
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


    public function addFavorite(Request $request)
    {

        $check = Favorite::where([
            'user_id' => $request['user_id'],
            'property_id' => $request['propertyID'],
        ])->first();

        if (empty($check)) {
            Favorite::insert([
                'user_id' => $request['user_id'],
                'property_id' => $request['propertyID'],
            ]);
        }

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'propertyID'
                    => $request['propertyID'],
                ]
            ],
            200
        );
    }


    public function getFavorite(Request $request)
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'properties'
                    => Favorite::where('user_id', $request['user_id'])->pluck('property_id')
                ]
            ],
            200
        );
    }


    public function getUserFavoriteProperties(Request $request)
    {

        $favList = Favorite::where('user_id', $request['user_id'])->pluck('property_id')->toArray();

        $properytList = Property::propertiesQuery()->whereIn('properties.id', $favList)->get();


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'properties' => $properytList,

                ]
            ],
            200
        );
    }





    public function removeFavorite(Request $request)
    {
        Favorite::where([
            'user_id' => $request['user_id'],
            'property_id' => $request['propertyID'],
        ])->delete();

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'properties'
                    => Favorite::where('user_id', $request['user_id'])->pluck('property_id')
                ]
            ],
            200
        );
    }


    public function uploadPropertyCompanyLogo(Request $request)
    {
        $request->validate([
            'property_id' => 'required', // Ensure user exists
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate logo file
        ]);

        // Retrieve the user by ID
        $property = Property::findOrFail($request->property_id);

        // Check if there's an existing logo and delete it
        if ($property->company_logo && file_exists(public_path($property->company_logo))) {
            unlink(public_path($property->company_logo)); // Delete existing logo
        }

        // Move the new logo file to the public/company_logos folder
        $file = $request->file('logo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = 'company_logos/' . $filename;
        $file->move(public_path('company_logos'), $filename);

        // Update the user's logo path in the database
        $property->company_logo = $filePath;
        $property->save();

        return response()->json([
            'message' => 'Company logo uploaded successfully',
            'company_logo_url' => asset($filePath) // Return the public URL of the logo
        ], 200);
    }


    public function reportProperty(Request $request)
    {

        $propertyDetails = Property::getPropertyByID($request['propertyID']);
        $user = User::where('id', $request['user_id'])->first();

        // Prepare the email data
        $emailData = [
            'property_name' => $propertyDetails->property_title,
            'reason' => $request['reason'],
            'description' => $request['description'],
            'created_by_name' => $propertyDetails->created_by_name,
            'location' => $propertyDetails->address . ", " . $propertyDetails->sub_region_name . ", " . $propertyDetails->town_name,
            'user_name' => !empty($user) ? $user->name : '',
            'user_email' => !empty($user) ? $user->email : '',
            'telephone' => !empty($user) ? $user->telephone : '',
        ];

        // Send the email only if at least one user-related detail is available
        if (!empty($emailData['user_name']) || !empty($emailData['user_email']) || !empty($emailData['telephone'])) {
            Mail::send(
                'mailing.report_ad.report',
                $emailData,
                function ($message) use ($request, $propertyDetails) {
                    $message->from('app@justhomesapp.com', 'Just Homes');
                    $message->to('thejustgrouplimited@gmail.com')->subject("New Ad Report: - " . $propertyDetails->property_title . " - Just Homes.");
                }
            );
        }
        if (!empty($user->email)) {
            Mail::send(
                'mailing.report_ad.report_confirm',
                [
                    'property_name' => $propertyDetails->property_title,
                    'reason' => $request['reason'],
                    'description' => $request['description'],
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'telephone' => $user->telephone,
                    'created_by_name' => $propertyDetails->created_by_name,
                    'location' => $propertyDetails->address . ", " . $propertyDetails->sub_region_name . ", " . $propertyDetails->town_name,
                ],
                function ($message) use ($request, $propertyDetails, $user) {
                    $message->from('app@justhomesapp.com', 'Just Homes');
                    $message->to($user->email)->subject("New Ad Report:" . " - " . $propertyDetails->property_title . " - Just Homes.");
                }
            );
        }
    }



    public function uploadPropertyImage(Request $request)

    {

        // dd("here");
        // // Validate the request to ensure a file is uploaded and it is an image
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // You can adjust the max size as needed
        // ]);

        // Check if the file is uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Generate a random file name and move the file to the /public/uploads/images directory
            $fileName = Str::random(30) . "." . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/images'), $fileName);

            // Return the file path as JSON response
            return response()->json([
                'status' => 'success',
                'image_path' => "uploads/images/" . $fileName
            ]);
        }

        // Return an error response if the file is not uploaded
        return response()->json([
            'status' => 'error',
            'message' => 'Image upload failed. Please try again.'
        ], 400);
    }





    public function approve(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|integer|exists:properties,id',
            'action' => 'required|in:approve,reject',
            // 'comment' => 'nullable|string|max:1000',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Update property status
            $property = Property::findOrFail($request['property_id']);
            $property->update([
                'is_active' => $request['action'] == 'approve' ? PropertyStatuses::PUBLISHED : PropertyStatuses::REJECTED,
                'reject_comment' => $request['comment'],
                'updated_by' => $request['user_id'],
                'updated_at' => Carbon::now(),
            ]);

            // Fetch property details
            $propertyDetails = Property::getPropertyByID($request['property_id']);

            // Send notification email
            Mail::send(
                'mailing.admin.approve_notify',
                [
                    'property_title' => $propertyDetails->property_title,
                    'created_by_name' => $propertyDetails->created_by_name,
                    'comment' => $request['comment'],
                    'action' => $request['action'],
                ],
                function ($message) use ($propertyDetails, $request) {
                    $subject = ($request['action'] == 'approve' ? 'APPROVED' : 'DECLINED') . ": {$propertyDetails->property_title}";
                    $message->from('app@justhomesapp.com', 'Just Homes');
                    $message->to($propertyDetails->email);
                    $message->subject($subject);
                }
            );

            return response()->json([
                'status' => 'success',
                'message' => "Property {$request['action']} successfully.",
            ]);
        } catch (\Exception $e) {
            Log::error('Property approval error', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing the request. Please try again later.',
            ], 500);
        }
    }


    public function deletePropertyImage(Request $request)
    {
        // Validate the request to ensure the path is provided
        // $request->validate([
        //     'image_path' => 'required|string',
        // ]);

        // Get the image path from the request
        $imagePath = $request->input('image_path');

        // Construct the full path to the image
        $fullImagePath = public_path($imagePath);

        // Check if the file exists and delete it
        if (File::exists($fullImagePath)) {
            File::delete($fullImagePath);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Image deleted successfully.',
            ]);
        }

        // Return an error response if the file does not exist
        return response()->json([
            'status' => 'error',
            'message' => 'Image not found.',
        ], 404);
    }


    public function editProperty(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'propertyTitle' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'user_id' => 'required|integer|exists:users,id',
                'propertyID' => 'required|integer|exists:properties,id',
                'images' => 'sometimes|string',
                'removedImages' => 'sometimes|string|nullable', // Make it nullable
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get or create town and subregion
            $town = Town::firstOrCreate(
                ['town_name' => $request->input('town', 'Nairobi')],
                ['is_active' => 1]
            );

            $subRegion = SubRegion::firstOrCreate(
                [
                    'sub_region_name' => $request->input('subRegion', 'Nairobi'),
                    'town_id' => $town->id
                ],
                ['is_active' => 1]
            );

            // Update property
            $property = Property::find($request->propertyID);
            $property->update([
                'property_title' => $request->propertyTitle,
                'town_id' => $town->id,
                'region_id' => $subRegion->id,
                'coordinates' => $request->latitude . ',' . $request->longitude,
                'lat' => $request->latitude,
                'log' => $request->longitude,
                'country' => $request->country ?? 'KENYA',
                'country_code' => $request->countryCode ?? 'KE',
                'google_address' => $request->address,
                'updated_by' => $request->user_id,
            ]);

            // Process removed images only if provided and not empty
            if ($request->filled('removedImages') && trim($request->removedImages) !== '') {
                $removedImages = array_filter(explode(',', $request->removedImages));
                if (!empty($removedImages)) {
                    PropertyImage::where('property_id', $property->id)
                        ->whereIn('image', $removedImages)
                        ->delete();
                }
            }

            // Process new images only if provided
            if ($request->filled('images') && trim($request->images) !== '') {
                $existingImages = PropertyImage::where('property_id', $property->id)
                    ->pluck('image')
                    ->toArray();

                $newImages = array_diff(
                    array_filter(explode(',', $request->images)),
                    $existingImages
                );

                foreach ($newImages as $image) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image' => trim($image),
                        'created_by' => $request->user_id,
                        'updated_by' => $request->user_id,
                    ]);
                }
            }

            // Update thumbnail
            $thumbnail = PropertyImage::where('property_id', $property->id)
                ->orderBy('created_at')
                ->first();

            $property->update([
                'thumbnail' => $thumbnail ? $thumbnail->image : 'images/back5.jpg'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => ['propertyID' => $property->id]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Property edit error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the property',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
