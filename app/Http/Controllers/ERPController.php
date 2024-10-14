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
            $agents = User::where('is_active', 1)->where('is_agent', 1)->get([
                'name',
                'email',
                'telephone',
                'company_name',
                'website',
                'profile',
                'avatar',
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
}
