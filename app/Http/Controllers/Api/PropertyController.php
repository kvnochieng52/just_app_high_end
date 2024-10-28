<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
use App\Models\ReportIssueReason;

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
                $property = new Property();
                $property->property_title = $request['title'];
                $property->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title')));
                $property->region_id = $request['region'];
                $property->town_id = $request['town'];
                $property->created_by = $request['user_id'];
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

                    $video_data = OpenGraph::fetch($request['youtubeLink']);

                    Property::where('id', $request['propertyID'])->update([
                        'video_link' => $request['youtubeLink'],
                        'video_thumb' => $video_data['image'],
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

                $updateArray = [
                    'company_name' => $request['companyName'],
                    'listing_as' => $request['listingAs'],
                    'is_active' => 1,
                    'updated_by' => $request['userID'],
                    'updated_at' => Carbon::now()->toDateTimeString()
                ];


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

                Property::where('id', $request['propertyID'])->update([
                    'property_title' => $request['title'],
                    'slug' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title'))),
                    'region_id' => $request['region'],
                    'town_id' => $request['town'],
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => $request['userID'],
                ]);
                $property =  Property::find($request['propertyID']);
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
        }
    }


    public function details(Request $request)
    {

        $propertyDetails = Property::getPropertyByID($request['propertyID']);
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


        $data->where('properties.is_active', 1);

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
                $message->from('noreply@justhomes.co.ke');
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
                'housesCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 2)->count(),
                'officeCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 3)->count(),
                'landsCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 7)->count(),
                'townHousesCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 5)->count(),
                'shopsCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 6)->count(),
                'villasCount' => Property::where('created_by', $request['user_id'])->where('lease_type_id', 4)->count(),
                'recentMessages' => Message::leftJoin('properties', 'messages.property_id', 'properties.id')
                    ->leftJoin('property_types', 'properties.type_id', 'property_types.id')
                    ->where('messages.user_id', $request['user_id'])
                    ->take(5)
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

        Mail::send(
            'mailing.report_ad.report',
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
            function ($message) use ($request, $propertyDetails) {
                $message->from('noreply@justhomes.co.ke', 'Just Homes');
                $message->to('kvnochieng52@gmail.com')->subject("New Ad Report:" . " - " . $propertyDetails->property_title . " - Just Homes.");
            }
        );
    }
}
