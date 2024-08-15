<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\LeaseType;
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

class PropertyController extends Controller
{
    public function getInitDataPartOne(Request $request)
    {
        return response()->json([
            "success" => true,
            "data" => [
                'townsList' => Town::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'town_name as value']),
                'subRegions' => SubRegion::where(['is_active' => 1])->orderBy('order', 'ASC')->get(['sub_region_name AS value', 'id', 'town_id']),
                'PropertyTypesList' => PropertyType::where('property_type_is_active', 1)->orderBy('order', 'ASC')->get(['id', 'property_type_name as value']),
                'propertyConditionsList' => PropertyCondition::where('is_active', 1)->orderBy('order', 'ASC')->get(['id',  'condition_name as value']),
                'furnishedList' => PropertyFurnish::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'furnish_name as value']),
                'leaseTypesList' => LeaseType::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'lease_type_name as value']),
                'propertyFeaturesList' => PropertyFeature::where('is_active', 1)->orderBy('order', 'ASC')->get(['id', 'feature_name']),
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
                    'condition_id' => $request['propertyCondition'],
                    'furnish_id' => $request['furnished'],
                    'parking_spaces' => $request['parking'],
                    'measurements' => $request['measurement'],
                    'bedrooms' => $request['bedrooms'],
                    'address' => $request['address'],
                    'lease_type_id' => $request['leaseType'],
                    'property_description' => $request['description'],
                    'amount' => $request['amount'],
                    'updated_by' => $request['userID'],
                    'updated_at' => Carbon::now()->toDateTimeString()
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
                if (!empty($request['selectedFeatures'])) {

                    PropertySelectedFeauture::where('property_id', $request['propertyID'])->delete();
                    foreach ($request['selectedFeatures'] as $key => $feature) {

                        if ($feature["checked"]) {
                            PropertySelectedFeauture::insert([
                                'property_id' => $request['propertyID'],
                                'group_id' => PropertyFeature::where('id', $feature["id"])->first()->property_feature_group_id,
                                'feature_id' => $feature["id"],
                                'created_by' => $request['userID'],
                                'updated_by' => $request['userID'],
                                'created_at' => Carbon::now()->toDateTimeString(),
                                'updated_at' => Carbon::now()->toDateTimeString()
                            ]);
                        }
                    }
                }


                Property::where('id', $request['propertyID'])->update([
                    'is_active' => 1,
                    'updated_by' => $request['userID'],
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);

                return response()->json([
                    "success" => true,
                    'data' => ['propertyID' => $request['propertyID'],],
                ]);

                break;
        }
    }


    public function details(Request $request)
    {
        return response()->json([
            "success" => true,
            "data" => [
                'propertyDetails' => Property::getPropertyByID($request['propertyID']),
                'propertyImages' => PropertyImage::getPropertyImages($request['propertyID']),
                'propertyFaetures' => PropertySelectedFeauture::where('property_id', $request['propertyID'])
                    ->leftJoin('property_features', 'property_selected_feautures.feature_id', 'property_features.id')
                    ->get([
                        // 'property_selected_feautures.id',
                        'property_features.feature_name'
                    ]),
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



    public function contactAgent(Request $request)
    {



        $propertyDetails = Property::getPropertyByID($request['propertyID']);



        if (!empty($propertyDetails)) {
            Mail::send('mailing.agent_email', ['data' => [
                'property_title' => $propertyDetails->property_title,
                'name' => $request['name'],
                'email' => $request['email'],
                'telephone' => $request['telephone'],
                'message' =>  $request['message']
            ]], function ($message) use ($request, $propertyDetails) {
                $message->from('notifications@justapartments.net');
                $message->to($propertyDetails->email)->subject("New Message From Just Apartment from Property: " . $propertyDetails->property_title);
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
}
