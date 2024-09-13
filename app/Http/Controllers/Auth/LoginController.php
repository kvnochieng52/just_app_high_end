<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }


    public function loginAttempt(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended();
        }
        return redirect("/login")->with('error', 'Invalid Credentials. Please check and try again.');
    }


    public function logout(Request $request)
    {

        Auth::logout();
        return redirect('/login');
    }

    public function google()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->_registerorLoginUser($user, $request);
        // return redirect()->route('home');
        // return redirect()->intended();

        return redirect('/dashboard');
    }


    public function facebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }


    public function handleFacebookCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $this->_registerorLoginUser($user, $request);
        //  return redirect()->route('home');
        return redirect()->intended();
    }



    protected function _registerOrLoginUser($data, Request $request)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->is_active = 1;
            $user->save();

            DB::table('model_has_roles')->insert([
                'role_id' => 2,
                'model_type' => 'Models\App\User',
                'model_id' => $user->id,
            ]);

            self::welcomeEmail($user);
        }


        if (Auth::login($user)) {
        } else {
            return back();
        }
    }



    public static function welcomeEmail($userDetails)
    {
        return  Mail::send(
            'mailing.register.welcome',
            [
                // 'resetCode' => $userDetails->reset_code,
                'name' => $userDetails->name,
            ],
            function ($message) use ($userDetails) {
                $message->from('noreply@justhomes.co.ke');
                $message->to($userDetails->email)->subject("Welcome|Karibu to Just Homes.");
            }
        );
    }
}
