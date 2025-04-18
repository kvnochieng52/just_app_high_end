<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Property;
use App\Models\SMS;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AppVersionController extends Controller
{


    public function latestVersion(Request $request)
    {
        return response()->json([
            'android_version' => '5.0.3',
            'ios_version' => '5.0.4',
            'force_update' => false // set to true to force update
        ]);
    }
}
