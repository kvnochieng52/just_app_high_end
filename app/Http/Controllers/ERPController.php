<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertySelectedFeauture;
use App\Models\SubRegion;
use App\Models\Town;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ERPController extends Controller
{
    public function getProperties(Request $request)
    {
        try {
            // Fetch active properties
            $properties = Property::propertiesQuery()->where('properties.is_active', 1)->get();

            // Check if properties exist
            if ($properties->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No properties found',
                    'data' => []
                ], 404);
            }

            // Return properties as JSON
            return response()->json([
                'success' => true,
                'message' => 'Properties retrieved successfully',
                'data' => $properties
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return an error response
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving properties: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function getAgents(Request $request)
    {
        try {
            // Fetch active agents (assuming 'is_agent' column exists)
            $agents = User::where('is_active', 1)->get([
                'name',
                'email',
                'telephone',
                'company_name',
                'website',
                'profile',
                'avatar',
                'created_at',
            ]);

            // Check if agents exist
            if ($agents->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No agents found',
                    'data' => []
                ], 404);
            }

            // Return agents as JSON
            return response()->json([
                'success' => true,
                'message' => 'Agents retrieved successfully',
                'data' => $agents
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return an error response
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving agents: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function post(Request $request)
    {

        $property = new Property();
        $property->property_title = $request['title'];
        $property->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title')));
        $property->region_id = $request['region'];
        $property->town_id = $request['town'];
        $property->town_id = $request['town'];
        $property->type_id = $request['propertyType'];
        $property->condition_id = $request['propertyCondition'] !== 'null' ? $request['propertyCondition'] : null;
        $property->furnish_id = $request['furnished'] !== 'null' ? $request['furnished'] : null;
        $property->parking_spaces = $request['parking'] !== 'null' ? $request['parking'] : null;
        $property->measurements = $request['measurement'] !== 'null' ? $request['measurement'] : null;
        $property->bedrooms = $request['bedrooms'] !== 'null' ? $request['bedrooms'] : null;
        $property->address = $request['address'];
        $property->lease_type_id = $request['leaseType'];
        $property->property_description = $request['description'];
        $property->amount = $request['amount'];
        $property->updated_by = $request['userID'];
        $property->updated_at = Carbon::now()->toDateTimeString();
        $property->on_auction = $request['auction'];
        $property->on_offplan = $request['offplan'];
        $property->on_offplan = $request['offplan'];
        $property->land_type_id = $request['landType'];
        $property->land_measurement_id = $request['landMeasurementID'] !== 'null' ? $request['landMeasurementID'] : null;
        $property->land_measurement_name = $request['landMeasurementName'] !== 'null' ? $request['landMeasurementName'] : null;
        $property->government_house = $request['governmentHousing'];

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
    }



    public function propertyDetails($propertyID)
    {

        $propertyDetails = Property::getPropertyByID($propertyID);
        return response()->json([
            "success" => true,
            "data" => [
                'propertyDetails' => $propertyDetails,
                'propertyImages' => PropertyImage::getPropertyImages($propertyID),
                'propertyFaetures' => PropertySelectedFeauture::where('property_id', $propertyID)
                    ->leftJoin('property_features', 'property_selected_feautures.feature_id', 'property_features.id')
                    ->get([
                        'property_features.feature_name'
                    ]),
            ],
        ]);
    }


    public function updateProperty(Request $request, $propertyID)
    {

        $property = Property::find($propertyID);
        $property->property_title = $request['title'];
        $property->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('title')));
        $property->region_id = $request['region'];
        $property->town_id = $request['town'];
        $property->town_id = $request['town'];
        $property->type_id = $request['propertyType'];
        $property->condition_id = $request['propertyCondition'] !== 'null' ? $request['propertyCondition'] : null;
        $property->furnish_id = $request['furnished'] !== 'null' ? $request['furnished'] : null;
        $property->parking_spaces = $request['parking'] !== 'null' ? $request['parking'] : null;
        $property->measurements = $request['measurement'] !== 'null' ? $request['measurement'] : null;
        $property->bedrooms = $request['bedrooms'] !== 'null' ? $request['bedrooms'] : null;
        $property->address = $request['address'];
        $property->lease_type_id = $request['leaseType'];
        $property->property_description = $request['description'];
        $property->amount = $request['amount'];
        $property->updated_by = $request['userID'];
        $property->updated_at = Carbon::now()->toDateTimeString();
        $property->on_auction = $request['auction'];
        $property->on_offplan = $request['offplan'];
        $property->on_offplan = $request['offplan'];
        $property->land_type_id = $request['landType'];
        $property->land_measurement_id = $request['landMeasurementID'] !== 'null' ? $request['landMeasurementID'] : null;
        $property->land_measurement_name = $request['landMeasurementName'] !== 'null' ? $request['landMeasurementName'] : null;
        $property->government_house = $request['governmentHousing'];

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

        PropertyImage::where('property_id')->delete();

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
    }
}
