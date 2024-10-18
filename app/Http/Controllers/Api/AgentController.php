<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    public function agentList(Request $request)
    {
        try {
            // Fetch active agents with the count of their active properties
            $agentDetails = User::withCount(['properties' => function ($query) {
                $query->where('is_active', 1);
            }])->where('is_active', 1)->get();

            return response()->json([
                'status' => 'success',
                'data' => $agentDetails
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching agent list: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the agent list. Please try again later.'
            ], 500);
        }
    }



    public function agentProperties(Request $request)
    {
        // Validate the incoming request to ensure agentID is present
        $validatedData = $request->validate([
            //'agentID' => 'required|integer|exists:agents,id', // Assuming you have an agents table
        ]);

        try {
            // Fetch properties for the agent
            $agentProperties = Property::propertiesQuery()
                ->where('properties.is_active', 1)
                ->where('properties.created_by', $request['agentID'])
                ->get();

            // Check if properties are found
            if ($agentProperties->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No properties found for this agent.',
                    'data' => [],
                ], 404); // Not Found status
            }

            // Return the properties as a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Properties retrieved successfully.',
                'data' => $agentProperties,
            ], 200); // OK status
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving properties.',
                'error' => $e->getMessage(), // Include the error message for debugging
            ], 500); // Internal Server Error status
        }
    }
}
