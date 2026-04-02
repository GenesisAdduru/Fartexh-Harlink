@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Verification Detail')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
@php
    $type = $type ?? 'donor';
    $reference = $reference ?? 'N/A';
    $isDonor = $type === 'donor';
@endphp

<section class="section-wrap reveal staff-page">
    <div class="section-title-block">
        <h1>{{ $isDonor ? 'Donor Hair Verification' : 'Recipient Request Verification' }}</h1>
        <p>Reference: <strong>{{ $reference }}</strong></p>
    </div>

    <article class="staff-block verification-detail-shell">
        <div class="verification-grid">
            <section>
                <h2>Submission Summary</h2>
                @if($isDonor)
                    <ul class="verification-list">
                        <li><strong>Name:</strong> Fiona Can</li>
                        <li><strong>Hair Length:</strong> Long</li>
                        <li><strong>Hair Color:</strong> Black</li>
                        <li><strong>Hair Condition:</strong> Untreated</li>
                        <li><strong>Submitted:</strong> 2026-03-25 09:14</li>
                    </ul>
                @else
                    <ul class="verification-list">
                        <li><strong>Name:</strong> Maria Santos</li>
                        <li><strong>Medical Need:</strong> Chemotherapy</li>
                        <li><strong>Preferred Wig Size:</strong> Long</li>
                        <li><strong>Preferred Color:</strong> Black</li>
                        <li><strong>Submitted:</strong> 2026-03-26 14:08</li>
                    </ul>
                @endif
            </section>

            <section>
                <h2>Attached Files</h2>
                <ul class="verification-list">
                    @if($isDonor)
                        <li>hair-photo-front.jpg</li>
                        <li>hair-photo-side.jpg</li>
                    @else
                        <li>medical-certificate.pdf</li>
                        <li>doctor-diagnosis.jpg</li>
                        <li>recipient-photo.jpg</li>
                    @endif
                </ul>
                <div class="empty-note">Preview placeholders only for frontend demo.</div>
            </section>
        </div>
    </article>

    <article class="staff-block">
        <h2>Verification Decision</h2>
        <form class="verification-form" data-verification-form novalidate>
            <div class="form-group">
                <label for="decisionRemarks">Remarks <span class="required">*</span></label>
                <textarea id="decisionRemarks" rows="4" placeholder="Add validation remarks and rationale..." required></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="soft-btn" data-decision-btn data-decision="approved">Approve</button>
                <button type="button" class="ghost-btn" data-decision-btn data-decision="rejected">Reject</button>
                <a class="ghost-btn" href="{{ $isDonor ? route('staff.donor-verification') : route('staff.recipient-verification') }}">Back to Queue</a>
            </div>
        </form>

        <p class="decision-banner" data-decision-banner hidden></p>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
