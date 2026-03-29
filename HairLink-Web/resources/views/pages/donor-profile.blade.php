@extends('layouts.dashboard')

@section('title', 'HairLink | Donor Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
    <section class="section-wrap profile-shell reveal" data-profile-page data-profile-type="donor">
        <header class="profile-head">
            <h1>My Profile</h1>
            <p>View your donor account details and contact information.</p>
        </header>

        <article class="profile-card">
            <div class="profile-hero">
                <div class="profile-avatar" id="profileInitials">HL</div>
                <div>
                    <p class="profile-name" id="profileName">HairLink User</p>
                    <span class="profile-role" id="profileRole">Donor</span>
                </div>
            </div>

            <div class="profile-grid">
                <div class="profile-item">
                    <small>Email</small>
                    <strong id="profileEmail">Not set</strong>
                </div>
                <div class="profile-item">
                    <small>Phone Number</small>
                    <strong id="profilePhone">Not set</strong>
                </div>
                <div class="profile-item">
                    <small>Age</small>
                    <strong id="profileAge">Not set</strong>
                </div>
                <div class="profile-item">
                    <small>Gender</small>
                    <strong id="profileGender">Not set</strong>
                </div>
                <div class="profile-item">
                    <small>Country</small>
                    <strong id="profileCountry">Not set</strong>
                </div>
                <div class="profile-item">
                    <small>Region / Province</small>
                    <strong id="profileRegion">Not set</strong>
                </div>
                <div class="profile-item">
                    <small>Postal Code</small>
                    <strong id="profilePostalCode">Not set</strong>
                </div>
            </div>

            <div class="profile-actions">
                <a class="soft-btn" href="{{ route('donor.dashboard') }}">Back to Dashboard</a>
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">Open Tracking</a>
            </div>
        </article>

        <article class="profile-stats">
            <div class="profile-stat">
                <small>Account Type</small>
                <strong>Donor</strong>
            </div>
            <div class="profile-stat">
                <small>Member Since</small>
                <strong id="profileJoined">-</strong>
            </div>
            <div class="profile-stat">
                <small>Quick Tip</small>
                <strong id="profileRouteHint">Use your dashboard to submit donations and track certificates.</strong>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/profile.js') }}" defer></script>
@endpush
