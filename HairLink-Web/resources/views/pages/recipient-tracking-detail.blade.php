@extends('layouts.dashboard')

@section('title', 'Request Details')

@section('content')
<div class="section-wrap">
    <div class="module-head">
        <h1>Request Details</h1>
        <p id="request-reference-display">Reference #{{ $requestData->reference }}</p>
    </div>

    <!-- Request Summary -->
    <div class="summary-grid">
        <div class="summary-item">
            <span class="summary-label">Reference</span>
            <span class="summary-value">{{ $requestData->reference }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Status</span>
            <span class="summary-value"><span class="status-pill status-{{ strtolower($requestData->status) }}">{{ $requestData->status }}</span></span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Submitted</span>
            <span class="summary-value">{{ $requestData->created_at->format('Y-m-d') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Name</span>
            <span class="summary-value">{{ $requestData->name }}</span>
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="timeline-section">
        <h3>Request Timeline</h3>
        <div class="timeline" id="request-timeline">
            @forelse($requestData->statusHistories()->orderBy('created_at', 'desc')->get() as $history)
            <div class="timeline-item">
                <div class="timeline-meta">
                    <strong>{{ $history->status }}</strong>
                    <small>{{ $history->created_at->format('M d, Y H:i') }}</small>
                </div>
                <div class="timeline-desc">
                    {{ $history->notes ?? 'Status changed to ' . $history->status }}
                </div>
            </div>
            @empty
            <div class="timeline-item">
                <div class="timeline-meta">
                    <strong>Submitted</strong>
                    <small>{{ $requestData->created_at->format('M d, Y H:i') }}</small>
                </div>
                <div class="timeline-desc">
                    Request record received and queued for review.
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Request Details Box -->
    <div class="details-box">
        <h3>Request Information</h3>
        <div class="details-content" id="request-details">
            <p><strong>Requirement:</strong> {{ $requestData->requirement ?? 'N/A' }}</p>
            <p><strong>Diagnosis:</strong> {{ $requestData->diagnosis ?? 'N/A' }}</p>
            <p><strong>Medical Certificate:</strong> {{ $requestData->medical_certificate ? 'Submitted' : 'Not Provided' }}</p>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('recipient.tracking') }}" class="soft-btn">Back to Requests</a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/recipient-module.js') }}" defer></script>
@endpush
