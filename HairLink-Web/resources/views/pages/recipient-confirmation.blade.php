@extends('layouts.dashboard')

@section('title', 'Request Submitted')

@section('content')
<div class="section-wrap">
    <div class="module-head">
        <h1>Request Submitted Successfully!</h1>
        <p>Thank you for trusting us with your journey. We're here to support you every step of the way.</p>
    </div>

    <!-- Success Icon -->
    <div class="success-icon-wrap">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
    </div>

    <!-- Submission Summary -->
    <div class="summary-grid">
        <div class="summary-item">
            <span class="summary-label">Reference Number</span>
            <span class="summary-value" id="confirmation-reference">-</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Status</span>
            <span class="summary-value" id="confirmation-status">-</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Full Name</span>
            <span class="summary-value" id="confirmation-name">-</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Submitted Date</span>
            <span class="summary-value" id="confirmation-submitted">-</span>
        </div>
    </div>

    <!-- Details Box -->
    <div class="details-box">
        <h3>Request Summary</h3>
        <div class="details-content" id="confirmation-details">
            <!-- Details rendered by JS -->
        </div>
    </div>

    <!-- Next Steps -->
    <div class="next-steps-box">
        <h3>What's Next?</h3>
        <ol class="next-steps-list">
            <li>We will review your request and supporting documents</li>
            <li>Our team will reach out to you directly via your contact number and email</li>
            <li>We'll discuss the details and coordinate your wig matching</li>
            <li>Once your wig is ready, we'll notify you for pickup or delivery</li>
        </ol>
    </div>

    <!-- Action Buttons -->
    <div class="form-actions">
        <a href="{{ route('recipient.tracking') }}" class="soft-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Track Status
        </a>
        <a href="{{ route('recipient.dashboard') }}" class="ghost-btn">Back to Dashboard</a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/recipient-module.js') }}" defer></script>
    <script src="{{ asset('assets/js/recipient-confirmation.js') }}" defer></script>
@endpush
