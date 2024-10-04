<?php

namespace App\Models;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'apple_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function generateAppleClientSecret()
    {
        // $keyId = env('APPLE_KEY_ID'); // Your Key ID
        // $teamId = env('APPLE_TEAM_ID'); // Your Team ID

        $keyId = 'CRWWL5FT6B';
        $teamId = 'ATY2NCJ569';
        $privateKey = file_get_contents(public_path('AuthKey_CRWWL5FT6B.p8')); // Path to your .p8 file in the public folder

        $token = [
            'iss' => $teamId,
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addMinutes(5)->timestamp,
            'aud' => 'https://appleid.apple.com',
            // 'sub' => env('APPLE_CLIENT_ID'), // Your Service ID
            'sub' => 'net.justapartments.app1'
        ];

        return JWT::encode($token, $privateKey, 'ES256', $keyId);
    }


    public static function checkUserProfile($userID)
    {
        // Retrieve the user based on user ID
        $user = User::where('id', $userID)->first();

        // Check if user exists and if name, email, and telephone are provided
        if ($user && !empty($user->name) && !empty($user->email) && !empty($user->telephone)) {
            return true;
        }

        return false;
    }
}
