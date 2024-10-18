<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    public function agentList(Request $request)
    {
        try {
            $agentDetails = User::where('is_active', '1')->get();

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
}
