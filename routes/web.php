<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AppleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ERPController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PlayStoreController;
use App\Http\Controllers\SearchController;
use App\Models\Calendar;
use App\Models\DPOController;
use Inertia\Inertia;


// Route::get('/ping', function () {
//     return response()->json(['status' => 'ok', 'timestamp' => now()->toIso8601String()]);
// })->middleware('auth:sanctum'); // Use the appropriate auth middleware for your app

// Route::get('/auth/apple', [AppleController::class, 'redirectToProvider']);
// Route::get('/auth/apple/callback', [AppleController::class, 'handleProviderCallback']);



// Route::get('/payment-success', function () {
//     return 'Payment successful.';
// })->name('payment.success');

// Route::get('/payment-cancelled', function () {
//     return 'Payment cancelled.';
// })->name('payment.cancel');





Route::post('/process-payment', [DPOController::class, 'processPayment']);
Route::post('/check-payment-status', [DPOController::class, 'checkPaymentStatus']);


Route::get('/payment-success', [DPOController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment-failed', [DPOController::class, 'paymentFailed'])->name('payment.failed');

Route::get('/payment-processing', [DPOController::class, 'paymentProcessing'])->name('payment.processing');




Route::post('/auth/apple', [AppleController::class, 'handleProviderCallback']);


Route::post('property/upload-drop-images', [PropertyController::class, 'uploadDropZoneImages']);



Route::get('/paystack/pay', [PaystackController::class, 'initiatePayment'])->name('paystack.pay');
Route::get('/paystack/callback', [PaystackController::class, 'handleCallback'])->name('paystack.callback');


Route::get('/password/reset', function () {
    return view('auth.passwords.reset');
})->middleware('guest')->name('password.reset');


//Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');


Route::prefix('agent')->group(function () {
    Route::get('/profile/{id}', [AgentController::class, 'profile'])->name('profile');
});



Route::get('/profile/{id}', [AgentController::class, 'profile'])->name('profile');




Route::get('/update-cordinates', [PropertyController::class, 'updateCordinates'])->name('updateCordinates');



Route::prefix('subscription')->group(function () {
    Route::get('/renew', [SubscriptionController::class, 'renew'])->name('subscription.renew');
    Route::post('/renew-process', [SubscriptionController::class, 'renewProcess'])->name('subscription.renew-process');
    Route::get('/status', [SubscriptionController::class, 'status'])->name('subscription.status');
});



Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');

    Route::get('/google', [LoginController::class, 'google']);
    Route::get('/google-android', [LoginController::class, 'googleAndroid']);



    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback']);

    Route::get('/google/android-callback', [LoginController::class, 'handleGoogleAndroidCallback']);

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
        Route::post('/submit', [CalendarController::class, 'submit']);
        Route::post('/check-date', [CalendarController::class, 'checkDate']);
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
        Route::delete('/quick-image-delete/{imageID}', [PropertyController::class, 'quickImageDelete']);
    });


    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/listing', [DashboardController::class, 'index'])->name('home');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
        Route::get('/edit-photo', [DashboardController::class, 'editPhoto'])->name('editPhoto');

        Route::get('/leads', [DashboardController::class, 'leads'])->name('leads');
        Route::post('/update-profile', [DashboardController::class, 'updateProfile']);
        Route::post('/upload-profile-photo', [DashboardController::class, 'uploadProfilePhoto']);



        Route::get('/heat-map/', [DashboardController::class, 'heatMap'])->name('heatMap');



        Route::get('/create', [DashboardController::class, 'create']);
        Route::post('/store', [DashboardController::class, 'store']);
        Route::get('/users', [DashboardController::class, 'users']);
        Route::get('/user-edit/{id}', [DashboardController::class, 'userEdit']);
        Route::post('/update-user', [DashboardController::class, 'updateUser']);
        Route::get('/user-delete/{id}', [DashboardController::class, 'userDelete']);
    });

    Route::prefix('admin')->group(function () {
        Route::get('/pending-approval', [AdminController::class, 'pendingApproval']);
        Route::get('/update-status/{id}', [AdminController::class, 'updateStatus']);
        Route::get('/all-listing', [AdminController::class, 'allProperties'])->name('allProperties');
        Route::post('/decision', [AdminController::class, 'decision']);
        Route::post('/bulk-approve', [AdminController::class, 'bulkApprove']);
        Route::post('/bulk-reject', [AdminController::class, 'bulkReject']);
    });
});

// Route::get('/', [HomeController::class, 'index']);


// Route::get('/', function (Illuminate\Http\Request $request) {
//     // If it's an Inertia request, return JSON
//     if ($request->header('X-Inertia')) {
//         return Inertia::render('Home/Home', [
//             'propertyTypes' => \App\Models\PropertyType::where('property_type_is_active', 1)
//                 ->orderBy('order', 'ASC')
//                 ->get(['id', 'property_type_name as name'])
//         ]);
//     }

//     // Otherwise, return a full HTML response
//     return Inertia::render('Home/Home', [
//         'propertyTypes' => \App\Models\PropertyType::where('property_type_is_active', 1)
//             ->orderBy('order', 'ASC')
//             ->get(['id', 'property_type_name as name'])
//     ])->toResponse($request);
// });


Route::get('/', [HomeController::class, 'index']);

Route::get('/privacy-policy', [HomeController::class, 'PrivacyPolicy']);

Route::get('/deactivate-account', [HomeController::class, 'deactivateAccount']);

Route::get('/services', [HomeController::class, 'services']);

Route::get('/terms-of-service', [HomeController::class, 'termsOfService']);
Route::get('/refund-policy', [HomeController::class, 'RefundPolicy']);
Route::get('/contact-us', [HomeController::class, 'contactUs']);
Route::get('/home/fetch_latest_listings', [HomeController::class, 'fetchLatestListings']);
Route::get('/home/fetch_properties_by_type/{type_slug}', [HomeController::class, 'fetchPropertiesByType']);
Route::get('/home/fetch_property_images/{property_id}', [HomeController::class, 'fetchPropertiesImage']);
Route::get('/product/search', [ProductController::class, 'search_product']);
Route::get('/home/fetch_location_axios/{location}', [HomeController::class, 'fetchLocationAxios']);
Route::post('/contact-submit', [HomeController::class, 'contactSubmit']);

Route::get('/home/government-housing', [HomeController::class, 'governmentHouses']);

Route::get('/home/sub-region-list/', [HomeController::class, 'addSubRegion']);
Route::post('/home/save-sub-region', [HomeController::class, 'saveSubRegion']);
Route::post('/home/toggle-sub-region-status', [HomeController::class, 'toggleSubregionStatus']);

Route::get('/get-downloads', [PlayStoreController::class, 'getDownloads']);


Route::get('/checkout-now', [PropertyController::class, 'checkoutNow']);
Route::post('/checkout-confirmation', [PropertyController::class, 'checkoutConfirmation']);





// Route::get('/category/{category_slug}', [ProductController::class, 'category_products']);
// Route::get('/{category_slug}/{product_slug}', [ProductController::class, 'product_details']);

Route::get('/properties/type/{property_type_slug}', [PropertyController::class, 'propertiesByType']);
Route::get('/{property_type}/{property_slug}', [PropertyController::class, 'propertyDetails']);
Route::get('/search', [SearchController::class, 'index']);

Route::post('/store-lead', [PropertyController::class, 'storeLead']);
Route::post('/send-message', [PropertyController::class, 'sendMessage']);



Route::prefix('erp')->group(function () {
    Route::post('/get-properties', [ERPController::class, 'getProperties'])->name('getProperties');
    Route::post('/get-agents', [ERPController::class, 'getAgents'])->name('getAgents');
    Route::post('/post', [ERPController::class, 'post'])->name('post');
    Route::post('/details/{propertyID}', [ERPController::class, 'propertyDetails'])->name('propertyDetails');
    Route::post('/update/{propertyID}', [ERPController::class, 'updateProperty'])->name('updateProperty');
    Route::post('/get-app-accounts', [ERPController::class, 'getAppAcconts'])->name('getAppAcconts');
});






Route::get('/download-calendar-event', function (Request $request) {
    $title = $request->get('title', 'Appointment');
    $description = $request->get('description', '');
    $startTime = $request->get('startTime');
    $endTime = $request->get('endTime');
    $location = $request->get('location', '');

    $icsContent = Calendar::generateICS($title, $startTime, $endTime, $description, $location);

    return response($icsContent)
        ->header('Content-Type', 'text/calendar')
        ->header('Content-Disposition', 'attachment; filename="appointment.ics"');
})->name('download-calendar-event');


// Route::get('/paystack/callback', [PaystackController::class, 'handleCallback'])->name('paystack.callback');
