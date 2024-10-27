<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AppleNotificationController;
use App\Http\Controllers\ReelsController;
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

        Route::post('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgotPassword');
        Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/activate-account', [UserController::class, 'activateAccount'])->name('activateAccount');
        Route::post('/resend-activate-code', [UserController::class, 'resendActivateCode'])->name('resendActivateCode');
        Route::post('/resend-verify-code', [UserController::class, 'resendVerifyCode'])->name('resendVerifyCode');
        Route::post('/test', [UserController::class, 'testsend'])->name('testsend');
        Route::post('/delete-profile', [UserController::class, 'deleteProfile'])->name('deleteProfile');
        Route::post('/upload-company-logo', [UserController::class, 'uploadCompanyLogo'])->name('uploadCompanyLogo');
    }
);


Route::prefix('property')->group(
    function () {
        Route::post('/get-init-data-part-one', [PropertyController::class, 'getInitDataPartOne'])->name('getInitDataPartOne');
        Route::post('/get-sub-regions', [PropertyController::class, 'getSubRegions'])->name('getSubRegions');
        Route::post('/get-sub-regions-and-post', [PropertyController::class, 'getSubRegionsPost'])->name('getSubRegions');
        Route::post('/post', [PropertyController::class, 'post'])->name('post');
        Route::post('/details', [PropertyController::class, 'details'])->name('details');

        Route::post('/dashboard-init-data', [PropertyController::class, 'dashboadInitData'])->name('dashboadInitData');
        Route::post('/search', [PropertyController::class, 'search'])->name('searchProperty');
        Route::post('/search-advanced', [PropertyController::class, 'searchAdvanced'])->name('searchAdvanced');

        Route::post('/contact-agent', [PropertyController::class, 'contactAgent'])->name('contactAgent');

        Route::post('/get-user-properties', [PropertyController::class, 'getUserProperties'])->name('getUserProperties');

        Route::post('/delete-property', [PropertyController::class, 'deleteProperty'])->name('deleteProperty');

        Route::post('/add-favorite', [PropertyController::class, 'addFavorite'])->name('Addfavorite');
        Route::post('/remove-favorite', [PropertyController::class, 'removeFavorite'])->name('removeFavorite');


        Route::post('/get-favorite', [PropertyController::class, 'getFavorite'])->name('getFavorite');

        Route::post('/get-stats', [PropertyController::class, 'getLeads'])->name('getLeads');

        Route::post('/get-favorite-list', [PropertyController::class, 'getUserFavoriteProperties'])->name('getUserFavoriteProperties');

        Route::post('/get-locations', [PropertyController::class, 'getLocations'])->name('getLocations');

        Route::post('/upload-property-company-logo', [PropertyController::class, 'uploadPropertyCompanyLogo'])->name('uploadCompanyLogo');








        // Route::post('/add-favorite', [PropertyController::class, 'addFavorites'])->name('addFavorites');
    }
);

Route::prefix('calendar')->group(
    function () {
        Route::post('/check-date', [CalendarController::class, 'checkDate'])->name('apiCheckDate');
        Route::post('/submit', [CalendarController::class, 'submit'])->name('apiCalendarSubmit');
        Route::post('/get-events', [CalendarController::class, 'getEvents'])->name('apiGetEvents');
        Route::post('/cancel-event', [CalendarController::class, 'cancelEvent'])->name('apiCancelEvent');
    }
);

Route::post('/apple/notifications', [AppleNotificationController::class, 'handleNotification']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('reels')->group(
    function () {
        Route::post('/upload-video', [ReelsController::class, 'uploadVideo'])->name('uploadVideo');
        Route::post('/get-videos', [ReelsController::class, 'getVideos'])->name('getVideos');
        Route::post('/get-video-updated-details', [ReelsController::class, 'getDetails'])->name('getDetails');

        Route::post('/post-comment', [ReelsController::class, 'postComment'])->name('postComment');
        Route::post('/update-likes', [ReelsController::class, 'updateLikes'])->name('updateLikes');
        Route::post('/update-shares', [ReelsController::class, 'updateShares'])->name('updateShares');
        Route::post('/get-likes-status', [ReelsController::class, 'getLikesStatus'])->name('getLikesStatus');
        Route::post('/get-user-reels', [ReelsController::class, 'getUserReels'])->name('getUserReels');
        Route::post('/delete-reel', [ReelsController::class, 'deleteReel'])->name('deleteReel');
    }
);



Route::prefix('agent')->group(
    function () {
        Route::post('/list', [AgentController::class, 'agentList'])->name('agentList');
        Route::post('/agent-properties', [AgentController::class, 'agentProperties'])->name('agentProperties');
    }
);
