<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {

        $user_role = 2;

        if (Auth::user()) {
            $roleDet = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();

            if (!empty($roleDet)) {
                $user_role = $roleDet->role_id;
            }
        }



        return array_merge(parent::share($request), [
            'auth' => Auth::user() ? [
                'user' => [
                    'name' => Auth::user()->name,
                    'id' => Auth::user()->id,
                    'avatar' => Auth::user()->avatar,
                    'user_role' => $user_role
                ],
            ] : null,
            'flash' => [
                'success' => $request->session()->get('success'),
                'error'  => $request->session()->get('error'),
            ],

            'currency' => env('CURRENCY', 'KES'),
            'country' => env('COUNTRY', 'KENYA'),
            'country_code' => env('COUNTRY_CODE', 'KE'),
        ]);
    }
}
