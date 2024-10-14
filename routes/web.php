<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AppleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ERPController;
use App\Http\Controllers\SearchController;


// Route::get('/auth/apple', [AppleController::class, 'redirectToProvider']);
// Route::get('/auth/apple/callback', [AppleController::class, 'handleProviderCallback']);

Route::post('/auth/apple', [AppleController::class, 'handleProviderCallback']);



Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');

    Route::get('/google', [LoginController::class, 'google']);
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);

    Route::get('/facebook', [LoginController::class, 'facebook']);
    Route::get('/facebook/callback', [LoginController::class, 'handleFacebookCallback']);

    Route::get('/logout', [LoginController::class, 'logout']);


    Route::post('/attempt', [LoginController::class, 'loginAttempt'])->name('loginAttempt');
});






Route::prefix('register')->group(function () {
    Route::get('/', [RegisterController::class, 'index'])->name('RegisterIndex');
    Route::post('/store', [RegisterController::class, 'store'])->name('RegisterStore');
});


Route::prefix('calendar')->group(
    function () {
        Route::post('/submit/', [CalendarController::class, 'submit']);
        Route::post('/check-date/', [CalendarController::class, 'checkDate']);
        Route::get('/', [CalendarController::class, 'calendar']);
        Route::get('/get-events', [CalendarController::class, 'getEvents']);
    }
);




Route::group(['middleware' => ['auth']], function () {


    Route::post('upload-images', [PropertyController::class, 'uploadImages']);
    Route::get('/post', [PropertyController::class, 'post'])->name('post');
    Route::get('/post-edit/{step}/{id}', [PropertyController::class, 'postEdit'])->name('postEdit');
    Route::get('/post-delete/{id}', [PropertyController::class, 'postDelete'])->name('postDelete');

    Route::prefix('property')->group(function () {
        Route::get('/fetch-sub-locations/{town_id}', [PropertyController::class, 'fetchSubLocations'])->name('fetchSubLocations');
        Route::get('/fetch-sub-properties/{type_id}', [PropertyController::class, 'fetchSubProperties'])->name('fetchSubProperties');
        Route::post('/store', [PropertyController::class, 'store']);
    });


    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/listing', [DashboardController::class, 'index'])->name('home');
        Route::get('/settings/', [DashboardController::class, 'settings'])->name('settings');
        Route::get('/edit-photo/', [DashboardController::class, 'editPhoto'])->name('editPhoto');

        Route::get('/leads', [DashboardController::class, 'leads'])->name('leads');
        Route::post('/update-profile', [DashboardController::class, 'updateProfile']);
        Route::post('/upload-profile-photo', [DashboardController::class, 'uploadProfilePhoto']);




        Route::get('/create', [DashboardController::class, 'create']);
        Route::post('/store', [DashboardController::class, 'store']);
        Route::get('/users', [DashboardController::class, 'users']);
        Route::get('/user-edit/{id}', [DashboardController::class, 'userEdit']);
        Route::post('/update-user', [DashboardController::class, 'updateUser']);
        Route::get('/user-delete/{id}', [DashboardController::class, 'userDelete']);
    });
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/privacy-policy', [HomeController::class, 'PrivacyPolicy']);
Route::get('/terms-of-service', [HomeController::class, 'termsOfService']);
Route::get('/contact-us', [HomeController::class, 'contactUs']);
Route::get('/home/fetch_latest_listings', [HomeController::class, 'fetchLatestListings']);
Route::get('/home/fetch_properties_by_type/{type_slug}', [HomeController::class, 'fetchPropertiesByType']);
Route::get('/home/fetch_property_images/{property_id}', [HomeController::class, 'fetchPropertiesImage']);
Route::get('/product/search', [ProductController::class, 'search_product']);
Route::get('/home/fetch_location_axios/{location}', [HomeController::class, 'fetchLocationAxios']);
Route::post('/contact-submit', [HomeController::class, 'contactSubmit']);




// Route::get('/category/{category_slug}', [ProductController::class, 'category_products']);
// Route::get('/{category_slug}/{product_slug}', [ProductController::class, 'product_details']);

Route::get('/properties/type/{property_type_slug}', [PropertyController::class, 'propertiesByType']);
Route::get('/{property_type}/{property_slug}', [PropertyController::class, 'propertyDetails']);
Route::get('/search/', [SearchController::class, 'index']);

Route::post('/store-lead/', [PropertyController::class, 'storeLead']);
Route::post('/send-message/', [PropertyController::class, 'sendMessage']);



Route::prefix('erp')->group(function () {
    Route::post('/get-properties', [ERPController::class, 'getProperties'])->name('getProperties');
    Route::post('/get-agents', [ERPController::class, 'getAgents'])->name('getAgents');
});
