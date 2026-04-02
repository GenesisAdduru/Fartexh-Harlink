<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('pages.landing');
});

Route::view('/login', 'pages.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::view('/register', 'pages.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('pages.verify-email');
})->middleware('auth')->name('verification.notice');

<<<<<<< HEAD
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    
    $user = $request->user();
    $redirect = $user->role === 'recipient' ? '/recipient/dashboard' : '/donor/dashboard';
    
    return redirect($redirect);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->expectsJson()) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    }
    
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/donor/dashboard', 'pages.donor-dashboard')->name('donor.dashboard');
    Route::view('/donor/donate', 'pages.donate-dashboard')->name('donor.donate');
    Route::view('/donor/tracking', 'pages.donor-tracking')->name('donor.tracking');
    Route::get('/donor/tracking/{reference}', function (string $reference) {
        return view('pages.donor-tracking-detail', compact('reference'));
    })->name('donor.tracking.detail');
    Route::view('/donor/confirmation', 'pages.donor-confirmation')->name('donor.confirmation');
    Route::view('/donor/certificate', 'pages.donor-certificate')->name('donor.certificate');
    Route::view('/donor/profile', 'pages.donor-profile')->name('donor.profile');
    Route::view('/donor/community', 'pages.donor-community')->name('donor.community');

    Route::view('/recipient/dashboard', 'pages.recipient-dashboard')->name('recipient.dashboard');
    Route::view('/recipient/request', 'pages.recipient-request')->name('recipient.request');
    Route::view('/recipient/tracking', 'pages.recipient-tracking')->name('recipient.tracking');
    Route::get('/recipient/tracking/{reference}', function (string $reference) {
        return view('pages.recipient-tracking-detail', compact('reference'));
    })->name('recipient.tracking.detail');
    Route::view('/recipient/confirmation', 'pages.recipient-confirmation')->name('recipient.confirmation');
    Route::view('/recipient/profile', 'pages.recipient-profile')->name('recipient.profile');
    Route::view('/recipient/community', 'pages.recipient-community')->name('recipient.community');
    Route::view('/recipient/haircare', 'pages.recipient-haircare')->name('recipient.haircare');

    // API Routes for AJAX interaction
    Route::prefix('api')->group(function () {
        // Donations
        Route::get('/donations', [App\Http\Controllers\Api\DonationController::class, 'index']);
        Route::post('/donations', [App\Http\Controllers\Api\DonationController::class, 'store']);
        Route::get('/donations/{reference}', [App\Http\Controllers\Api\DonationController::class, 'show']);
        Route::post('/donations/{reference}/status', [App\Http\Controllers\Api\DonationController::class, 'updateStatus']);

        // Hair Requests
        Route::get('/requests', [App\Http\Controllers\Api\HairRequestController::class, 'index']);
        Route::post('/requests', [App\Http\Controllers\Api\HairRequestController::class, 'store']);
        Route::get('/requests/{reference}', [App\Http\Controllers\Api\HairRequestController::class, 'show']);
        Route::post('/requests/{reference}/status', [App\Http\Controllers\Api\HairRequestController::class, 'updateStatus']);

        // Community
        Route::get('/community/posts', [App\Http\Controllers\Api\CommunityController::class, 'index']);
        Route::post('/community/posts', [App\Http\Controllers\Api\CommunityController::class, 'storePost']);
        Route::post('/community/posts/{post}/comments', [App\Http\Controllers\Api\CommunityController::class, 'storeComment']);
        Route::post('/community/posts/{post}/like', [App\Http\Controllers\Api\CommunityController::class, 'toggleLike']);
        Route::delete('/community/posts/{post}', [App\Http\Controllers\Api\CommunityController::class, 'destroyPost']);
        Route::delete('/community/comments/{comment}', [App\Http\Controllers\Api\CommunityController::class, 'destroyComment']);

        // Haircare
        Route::get('/haircare/articles', [App\Http\Controllers\Api\HaircareController::class, 'articles']);
        Route::get('/haircare/articles/{id}', [App\Http\Controllers\Api\HaircareController::class, 'article']);
        Route::get('/haircare/videos', [App\Http\Controllers\Api\HaircareController::class, 'videos']);
    });
});
=======
Route::view('/recipient/dashboard', 'pages.recipient-dashboard')->name('recipient.dashboard');
Route::view('/recipient/request', 'pages.recipient-request')->name('recipient.request');
Route::view('/recipient/tracking', 'pages.recipient-tracking')->name('recipient.tracking');
Route::get('/recipient/tracking/{reference}', function (string $reference) {
    return view('pages.recipient-tracking-detail', compact('reference'));
})->name('recipient.tracking.detail');
Route::view('/recipient/confirmation', 'pages.recipient-confirmation')->name('recipient.confirmation');
Route::view('/recipient/profile', 'pages.recipient-profile')->name('recipient.profile');
Route::view('/recipient/community', 'pages.recipient-community')->name('recipient.community');
Route::view('/recipient/haircare', 'pages.recipient-haircare')->name('recipient.haircare');

Route::get('/donor/monetary-donation', function () {
    return view('pages.monetary-donation', ['userRole' => 'donor']);
})->name('donor.monetary');

Route::get('/recipient/monetary-donation', function () {
    return view('pages.monetary-donation', ['userRole' => 'recipient']);
})->name('recipient.monetary');

Route::view('/wigmaker/dashboard', 'pages.wigmaker-dashboard')->name('wigmaker.dashboard');
Route::get('/wigmaker/tasks/{taskCode}', function (string $taskCode) {
    return view('pages.wigmaker-task-detail', compact('taskCode'));
})->name('wigmaker.task.detail');

Route::view('/staff/dashboard', 'pages.staff-dashboard')->name('staff.dashboard');
Route::view('/staff/donor-verification', 'pages.staff-donor-verification')->name('staff.donor-verification');
Route::view('/staff/recipient-verification', 'pages.staff-recipient-verification')->name('staff.recipient-verification');
Route::get('/staff/verification/{type}/{reference}', function (string $type, string $reference) {
    return view('pages.staff-verification-detail', compact('type', 'reference'));
})->whereIn('type', ['donor', 'recipient'])->name('staff.verification.detail');
Route::view('/staff/realtime-tracking', 'pages.staff-realtime-tracking')->name('staff.realtime-tracking');
Route::view('/staff/delivery-batches', 'pages.staff-delivery-batches')->name('staff.delivery-batches');
Route::view('/staff/hair-stock', 'pages.staff-hair-stock')->name('staff.hair-stock');
Route::view('/staff/wig-stock', 'pages.staff-wig-stock')->name('staff.wig-stock');
Route::view('/staff/recipient-matching-list', 'pages.staff-recipient-matching-list')->name('staff.recipient-matching-list');
Route::view('/staff/rule-matching', 'pages.staff-rule-matching')->name('staff.rule-matching');

Route::view('/admin/dashboard', 'pages.admin-dashboard')->name('admin.dashboard');
Route::view('/admin/verification', 'pages.admin-verification')->name('admin.verification');
Route::view('/admin/matching', 'pages.admin-matching')->name('admin.matching');
Route::view('/admin/operations', 'pages.admin-operations')->name('admin.operations');
Route::view('/admin/inventory', 'pages.admin-inventory')->name('admin.inventory');
Route::view('/admin/users', 'pages.admin-users')->name('admin.users');
Route::view('/admin/events', 'pages.admin-events')->name('admin.events');
Route::view('/admin/community', 'pages.admin-community')->name('admin.community');
Route::view('/admin/reports', 'pages.admin-reports')->name('admin.reports');
>>>>>>> origin/main
