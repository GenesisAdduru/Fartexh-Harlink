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
Route::post('/api/partnership', [App\Http\Controllers\PartnershipController::class, 'store'])->name('partnership.store');


// Email Verification Routes
Route::get('/email/verify', function () {
    return view('pages.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));
    }
    
    return redirect('/login')->with('success', 'Email verified successfully! You may now sign in.');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->expectsJson()) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    }
    
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {
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
        // Partnerships
        // Remaining sections...

    });

    Route::get('/donor/monetary-donation', function () {
        return view('pages.monetary-donation', ['userRole' => 'donor']);
    })->name('donor.monetary');

    Route::get('/recipient/monetary-donation', function () {
        return view('pages.monetary-donation', ['userRole' => 'recipient']);
    })->name('recipient.monetary');

    Route::get('/wigmaker/dashboard', [App\Http\Controllers\WigmakerController::class, 'dashboard'])->name('wigmaker.dashboard');
    Route::get('/wigmaker/tasks/{taskCode}', [App\Http\Controllers\WigmakerController::class, 'taskDetail'])->name('wigmaker.task.detail');
    Route::post('/wigmaker/tasks/{taskCode}/update', [App\Http\Controllers\WigmakerController::class, 'updateTask'])->name('wigmaker.task.update');

    Route::get('/staff/dashboard', [App\Http\Controllers\StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('/staff/donor-verification', [App\Http\Controllers\StaffController::class, 'donorVerification'])->name('staff.donor-verification');
    Route::get('/staff/recipient-verification', [App\Http\Controllers\StaffController::class, 'recipientVerification'])->name('staff.recipient-verification');
    Route::get('/staff/verification/{type}/{reference}', [App\Http\Controllers\StaffController::class, 'verificationDetail'])->whereIn('type', ['donor', 'recipient'])->name('staff.verification.detail');
    Route::post('/staff/verification/{type}/{reference}/status', [App\Http\Controllers\StaffController::class, 'updateVerificationStatus'])->whereIn('type', ['donor', 'recipient'])->name('staff.verification.status');
    Route::get('/staff/realtime-tracking', [App\Http\Controllers\StaffController::class, 'realtimeTracking'])->name('staff.realtime-tracking');
    Route::get('/staff/delivery-batches', [App\Http\Controllers\StaffController::class, 'deliveryBatches'])->name('staff.delivery-batches');
    Route::get('/staff/hair-stock', [App\Http\Controllers\StaffController::class, 'hairStock'])->name('staff.hair-stock');
    Route::get('/staff/wig-stock', [App\Http\Controllers\StaffController::class, 'wigStock'])->name('staff.wig-stock');
    Route::get('/staff/recipient-matching-list', [App\Http\Controllers\StaffController::class, 'recipientMatchingList'])->name('staff.recipient-matching-list');
    Route::get('/staff/rule-matching', [App\Http\Controllers\StaffController::class, 'ruleMatching'])->name('staff.rule-matching');

    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/verification', [App\Http\Controllers\AdminController::class, 'verification'])->name('admin.verification');
    Route::get('/admin/matching', [App\Http\Controllers\AdminController::class, 'matching'])->name('admin.matching');
    Route::get('/admin/operations', [App\Http\Controllers\AdminController::class, 'operations'])->name('admin.operations');
    Route::get('/admin/inventory', [App\Http\Controllers\AdminController::class, 'inventory'])->name('admin.inventory');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/events', [App\Http\Controllers\AdminController::class, 'events'])->name('admin.events');
    Route::get('/admin/community', [App\Http\Controllers\AdminController::class, 'community'])->name('admin.community');
    Route::get('/admin/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
});
