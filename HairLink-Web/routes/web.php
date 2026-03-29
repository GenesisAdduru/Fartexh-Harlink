<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landing');
});

Route::view('/login', 'pages.login')->name('login');
Route::view('/register', 'pages.register')->name('register');

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
