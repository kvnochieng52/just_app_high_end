<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class RegisterController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {


        $this->validate($request, [
            'fullNames' => 'required',
            'telephone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        $user = new User();
        $user->name = $request['fullNames'];
        $user->email = $request['email'];
        $user->is_active = 1;
        $user->password = Hash::make($request['password']);
        $user->telephone = $request['telephone'];
        $user->save();

        DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'Models\User',
            'model_id' => $user->id,
        ]);


        // $userProfile = new Profile();
        // $userProfile->user_id = $user->id;
        // $userProfile->telephone = $request['telephone'];
        // $userProfile->created_by = $user->id;
        // $userProfile->updated_by = $user->id;
        // $userProfile->save();


        return redirect('/login');

        // ->with('success', 'Registration successfull. Please verify your email!');
    }
}
