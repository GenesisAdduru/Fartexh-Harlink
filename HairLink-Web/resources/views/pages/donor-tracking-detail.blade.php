@extends('layouts.dashboard')

@section('title', 'HairLink | Tracking Detail')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/donor-module.css') }}">
@endpush

@section('content')
    <section class="section-wrap donor-module-page reveal" data-reference="{{ $reference }}" id="trackingDetailRoot">
        <header class="module-head">
            <h1>Donation Tracking Detail</h1>
            <p>Reference: <strong id="detailReference">{{ $reference }}</strong></p>
            <div class="action-row">
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">Back to Tracking List</a>
                <button id="simulateStatusBtn" class="soft-btn" type="button">Simulate Next Status</button>
            </div>
        </header>

        <article class="module-card">
            <div class="summary-grid">
                <div class="summary-item">
                    <small>Current Status</small>
                    <strong id="detailStatus">-</strong>
                    <div class="demo-row">
                        <span id="detailStatusPill" class="status-pill status-submitted">Submitted</span>
                    </div>
                </div>
                <div class="summary-item">
                    <small>Submitted On</small>
                    <strong id="detailSubmitted">-</strong>
                </div>
                <div class="summary-item">
                    <small>Donor</small>
                    <strong id="detailDonor">-</strong>
                </div>
                <div class="summary-item">
                    <small>Hair Details</small>
                    <strong id="detailHair">-</strong>
                </div>
            </div>

            <div class="note-box">
                Track each milestone below. Certificate becomes available once status reaches Completed.
            </div>
        </article>

        <article class="module-card">
            <h2>Donation Timeline</h2>
            <ul class="timeline" id="detailTimeline"></ul>
            <div class="action-row">
                <a id="detailCertificateBtn" class="soft-btn" href="{{ route('donor.certificate') }}">Open Certificate</a>
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-module.js') }}" defer></script>
    <script src="{{ asset('assets/js/donor-tracking-detail.js') }}" defer></script>
@endpush
