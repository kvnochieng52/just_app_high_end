<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class AppleController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('apple')->user();

        // Handle the user (e.g., create or update in your database)
    }
}
