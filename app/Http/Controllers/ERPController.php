<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class ERPController extends Controller
{
    public function getProperties(Request $request)
    {
        try {
            // Fetch active properties
            $properties = Property::propertiesQuery()->where('is_active', 1)->get();

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



    public function getUsers(Request $request)
    {
        try {
            // Fetch active users and select specific columns
            $users = User::where('is_active', 1)->get([
                'name',
                'email',
                'telephone',
                'company_name',
                'website',
                'tiktok',
                'facebook',
                'twitter',
                'profile',
                'avatar',
            ]);

            // Check if users exist
            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users found',
                    'data' => []
                ], 404);
            }

            // Return users as JSON
            return response()->json([
                'success' => true,
                'message' => 'Users retrieved successfully',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return an error response
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving users: ' . $e->getMessage(),
            ], 500);
        }
    }
}
