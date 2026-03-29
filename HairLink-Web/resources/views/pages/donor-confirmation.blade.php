@extends('layouts.dashboard')

@section('title', 'HairLink | Donation Confirmation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/donor-module.css') }}">
@endpush

@section('content')
    <section class="section-wrap donor-module-page reveal">
        <header class="module-head">
            <h1>Donation Submitted Successfully</h1>
            <p>Your hair donation is now recorded. Keep your reference number for tracking updates.</p>
        </header>

        <article class="module-card">
            <div class="summary-grid">
                <div class="summary-item">
                    <small>Donation Reference</small>
                    <strong id="confirmRef">-</strong>
                </div>
                <div class="summary-item">
                    <small>Current Status</small>
                    <strong id="confirmStatus">-</strong>
                    <div class="demo-row">
                        <span id="confirmStatusPill" class="status-pill status-submitted">Submitted</span>
                    </div>
                </div>
                <div class="summary-item">
                    <small>Donor Name</small>
                    <strong id="confirmDonor">-</strong>
                </div>
                <div class="summary-item">
                    <small>Submitted On</small>
                    <strong id="confirmSubmitted">-</strong>
                </div>
            </div>

            <div class="note-box" id="confirmDetails">-</div>

            <div class="action-row">
                <a id="openTrackingDetail" class="soft-btn" href="{{ route('donor.tracking') }}">Open Tracking Detail</a>
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">View All My Donations</a>
                <a id="openCertificate" class="soft-btn" href="{{ route('donor.certificate') }}">Open Donor Certificate</a>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-module.js') }}" defer></script>
    <script src="{{ asset('assets/js/donor-confirmation.js') }}" defer></script>
@endpush
