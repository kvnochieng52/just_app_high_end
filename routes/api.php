<?php

use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('user')->group(
    function () {
        Route::post('/social-media-login', [UserController::class, 'socialMediaLogin'])->name('socialMediaLogin');
        Route::post('/login', [UserController::class, 'login'])->name('login');
        Route::post('/register', [UserController::class, 'register'])->name('register');
        Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
        Route::post('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
    }
);


Route::prefix('property')->group(
    function () {
        Route::post('/get-init-data-part-one', [PropertyController::class, 'getInitDataPartOne'])->name('getInitDataPartOne');
        Route::post('/get-sub-regions', [PropertyController::class, 'getSubRegions'])->name('getSubRegions');
        Route::post('/post', [PropertyController::class, 'post'])->name('post');
        Route::post('/details', [PropertyController::class, 'details'])->name('details');

        Route::post('/dashboard-init-data', [PropertyController::class, 'dashboadInitData'])->name('dashboadInitData');
        Route::post('/search', [PropertyController::class, 'search'])->name('searchProperty');
        Route::post('/contact-agent', [PropertyController::class, 'contactAgent'])->name('contactAgent');

        Route::post('/get-user-properties', [PropertyController::class, 'getUserProperties'])->name('getUserProperties');

        Route::post('/delete-property', [PropertyController::class, 'deleteProperty'])->name('deleteProperty');

        Route::post('/add-favorite', [PropertyController::class, 'addFavorite'])->name('Addfavorite');
        Route::post('/remove-favorite', [PropertyController::class, 'removeFavorite'])->name('removeFavorite');


        Route::post('/get-favorite', [PropertyController::class, 'getFavorite'])->name('getFavorite');

        Route::post('/get-stats', [PropertyController::class, 'getLeads'])->name('getLeads');

        Route::post('/get-favorite-list', [PropertyController::class, 'getUserFavoriteProperties'])->name('getUserFavoriteProperties');









        Route::post('/get-locations', [PropertyController::class, 'getLocations'])->name('getLocations');
        // Route::post('/add-favorite', [PropertyController::class, 'addFavorites'])->name('addFavorites');
    }
);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
