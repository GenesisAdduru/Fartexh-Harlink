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
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Track Donations
                </a>
                <a class="ghost-btn" href="{{ route('donor.certificate') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="14" rx="2" ry="2"></rect>
                        <path d="M7 8h10"></path>
                        <path d="M7 12h6"></path>
                        <path d="M8 18l2 4 2-4"></path>
                        <path d="M14 18l2 4 2-4"></path>
                    </svg>
                    My Certificate
                </a>
                <a class="ghost-btn" href="{{ route('donor.community') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Community Support
                </a>
                <a class="ghost-btn" href="{{ route('donor.profile') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    My Profile
                </a>
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
