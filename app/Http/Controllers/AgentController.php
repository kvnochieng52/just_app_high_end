<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgentController extends Controller
{
    public function profile($userID)
    {


        $agentDetails = User::where('id', $userID)->first();

        return Inertia::render('Agent/Profile', [
            'agentDetails' => $agentDetails,
            'properties' => Property::propertiesQuery()->where('properties.created_by', $agentDetails->id)
                ->where('is_active', 1)
                ->paginate(10)
        ]);
    }
}
