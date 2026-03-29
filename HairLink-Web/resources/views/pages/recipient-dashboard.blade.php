@extends('layouts.dashboard')

@section('title', 'Recipient Dashboard')

@section('content')
<div class="section-wrap">
    <div class="module-head">
        <h1>Welcome, <span id="greeting-name">Friend</span>!</h1>
        <p>Your journey to confidence and self-expression starts here.</p>
    </div>

    <!-- Active Requests Card -->
    <div class="active-requests-card">
        <div class="card-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 11l3 3L22 4"></path>
                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="card-content">
            <h3>Active Requests</h3>
            <p id="active-requests-count">0</p>
        </div>
    </div>

    <!-- Guidelines and Actions Container -->
    <div class="guidelines-actions-container">
        <!-- Guidelines Box -->
        <div class="guidelines-box">
            <div class="guidelines-head">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                </svg>
                <h3>Before You Request</h3>
            </div>
            <div class="guidelines-items">
                <div class="guideline-item">
                    <span class="dot">•</span>
                    <span>Gather your medical documents (if applicable)</span>
                </div>
                <div class="guideline-item">
                    <span class="dot">•</span>
                    <span>Prepare your hair loss story and journey</span>
                </div>
                <div class="guideline-item">
                    <span class="dot">•</span>
                    <span>Prepare photos of yourself for reference</span>
                </div>
                <div class="guideline-item">
                    <span class="dot">•</span>
                    <span>Be ready to fill up the request form</span>
                </div>
            </div>
            <div class="guidelines-request-action">
                <a href="{{ route('recipient.request') }}" class="soft-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"></path>
                    </svg>
                    Request Hair
                </a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="recipient-actions">
            <a href="{{ route('recipient.tracking') }}" class="ghost-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                View Status
            </a>
            <a href="{{ route('recipient.community') }}" class="ghost-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Community Support
            </a>
            <a href="{{ route('recipient.haircare') }}" class="ghost-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 21h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2.68a2 2 0 0 1-1.44-.6l-.88-.88A2 2 0 0 0 9.68 4H8a2 2 0 0 0 0 4h.5"></path>
                    <path d="M8.5 8a2 2 0 0 0-2 2v8"></path>
                    <circle cx="15" cy="13" r="2"></circle>
                </svg>
                Hair Care
            </a>
            <a href="{{ route('recipient.profile') }}" class="ghost-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21a8 8 0 0 0-16 0"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                My Profile
            </a>
            <a href="{{ route('recipient.monetary') }}" class="ghost-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"></path>
                    <path d="M12 6v2m0 8v2m-4-5h2m4 0h2"></path>
                </svg>
                Monetary Donation
            </a>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/recipient-dashboard.js') }}"></script>
@endsection
