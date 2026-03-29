@extends('layouts.dashboard')

@section('title', 'HairLink | Donor Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/donor-dashboard.css') }}">
@endpush

@section('content')
    <section class="section-wrap reveal">
        <div class="section-title-block">
            <h1 id="greetingText">Welcome Back, Fiona Can!</h1>
            <p>Your impact snapshots and reward progress are shown below.</p>
        </div>

        <article class="points-card">
            <p class="points-info" id="pointsInfo">
                <i class='bx bx-info-circle'></i>
                10 points earned for every donation and 3 points for every referral.
                Star Points <span class="star-inline">★</span> <span id="pointValue">0</span>
            </p>

            <div class="progress-wrap" aria-label="Reward progress">
                <div class="progress-bar">
                    <span class="progress-fill" id="progressFill"></span>
                </div>
                <span class="progress-star" id="progressStar" title="Tap to simulate points">★</span>
            </div>

            <div class="star-row" aria-hidden="true">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>

            <p class="reward-line" id="rewardLine">Free wig for every 100 star points</p>
        </article>

        <section class="quick-actions">
            <div class="referral-box">
                <label for="referralCode">Referral Code</label>
                <input id="referralCode" type="text" placeholder="Enter code here">
                <button id="submitCodeBtn" class="soft-btn" type="button">Submit Code</button>
            </div>

            <div class="action-buttons">
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">Track Donations</a>
                <a class="ghost-btn" href="{{ route('donor.certificate') }}">My Certificate</a>
            </div>
        </section>

        <section class="rewards-shell reveal">
            <div class="rewards-head">
                <h2>Claimable Actions</h2>
                <i class='bx bxs-badge-check'></i>
            </div>

            <div class="reward-grid">
                <article class="reward-card">
                    <h3>Donate Hair</h3>
                    <p>Give confidence to someone in need by donating your hair.</p>
                    <a class="soft-btn" href="{{ route('donor.donate') }}">Donate</a>
                </article>

                <article class="reward-card">
                    <h3>Request Hair</h3>
                    <p>Apply for a free wig with your health documentation.</p>
                    <button class="soft-btn" type="button" disabled>Request</button>
                </article>

                <article class="reward-card">
                    <h3>Donation Tracking</h3>
                    <p>Review status updates and open your latest donor certificate.</p>
                    <a class="soft-btn" href="{{ route('donor.tracking') }}">Open Tracking</a>
                </article>
            </div>
        </section>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-dashboard.js') }}" defer></script>
@endpush
