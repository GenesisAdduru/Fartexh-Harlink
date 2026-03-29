@extends('layouts.dashboard')

@section('title', 'Request Details')

@section('content')
<div class="section-wrap">
    <div class="module-head">
        <h1>Request Details</h1>
        <p id="request-reference-display">Reference #</p>
    </div>

    <!-- Request Summary -->
    <div class="summary-grid">
        <div class="summary-item">
            <span class="summary-label">Reference</span>
            <span class="summary-value" id="summary-reference">-</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Status</span>
            <span class="summary-value" id="summary-status">-</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Submitted</span>
            <span class="summary-value" id="summary-submitted">-</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Name</span>
            <span class="summary-value" id="summary-name">-</span>
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="timeline-section">
        <h3>Request Timeline</h3>
        <div class="timeline" id="request-timeline">
            <!-- Timeline items rendered by JS -->
        </div>
    </div>

    <!-- Request Details Box -->
    <div class="details-box">
        <h3>Request Information</h3>
        <div class="details-content" id="request-details">
            <!-- Details rendered by JS -->
        </div>
    </div>

    <!-- Simulate Status (Testing) -->
    <div class="form-actions">
        <button id="simulate-status-btn" class="ghost-btn">Simulate Next Status</button>
        <a href="{{ route('recipient.tracking') }}" class="soft-btn">Back to Requests</a>
    </div>
</div>

<script src="{{ asset('assets/js/recipient-tracking-detail.js') }}"></script>
@endsection
