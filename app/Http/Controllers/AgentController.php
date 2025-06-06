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


        // dd($userID, Property::propertiesQuery()->where('properties.created_by', $userID)->where('properties.is_active', 1)->get());

        $agentDetails = User::where('id', $userID)->first();

        return Inertia::render('Agent/Profile', [
            'agentDetails' => $agentDetails,
            'properties' => Property::propertiesQuery()->where('properties.created_by', $userID)
                ->where('properties.is_active', 2)
                ->orderBy('properties.id', 'DESC')
                ->paginate(9)
        ]);
    }
}
