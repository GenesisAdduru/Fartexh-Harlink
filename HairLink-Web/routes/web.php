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
