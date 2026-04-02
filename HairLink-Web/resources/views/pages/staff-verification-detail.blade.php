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
                        <li><strong>Name:</strong> {{ $record->user->first_name ?? 'Unknown' }} {{ $record->user->last_name ?? '' }}</li>
                        <li><strong>Hair Length:</strong> {{ $record->hair_length }}</li>
                        <li><strong>Hair Color:</strong> {{ $record->hair_color }}</li>
                        <li><strong>Hair Condition:</strong> {{ $record->hair_condition }}</li>
                        <li><strong>Submitted:</strong> {{ $record->created_at->format('Y-m-d H:i') }}</li>
                    </ul>
                @else
                    <ul class="verification-list">
                        <li><strong>Name:</strong> {{ $record->user->first_name ?? 'Unknown' }} {{ $record->user->last_name ?? '' }}</li>
                        <li><strong>Medical Need:</strong> {{ $record->medical_condition }}</li>
                        <li><strong>Preferred Wig Size:</strong> {{ $record->preferred_length }}</li>
                        <li><strong>Preferred Color:</strong> {{ $record->preferred_color }}</li>
                        <li><strong>Submitted:</strong> {{ $record->created_at->format('Y-m-d H:i') }}</li>
                    </ul>
                @endif
            </section>

            <section>
                <h2>Attached Files</h2>
                <ul class="verification-list">
                    @if($isDonor)
                        @if($record->photo_front) <li><a href="{{ Storage::url($record->photo_front) }}" target="_blank">hair-photo-front.jpg</a></li> @endif
                        @if($record->photo_side) <li><a href="{{ Storage::url($record->photo_side) }}" target="_blank">hair-photo-side.jpg</a></li> @endif
                    @else
                        @if($record->medical_certificate) <li><a href="{{ Storage::url($record->medical_certificate) }}" target="_blank">medical-certificate.pdf</a></li> @endif
                        @if($record->diagnosis_photo) <li><a href="{{ Storage::url($record->diagnosis_photo) }}" target="_blank">doctor-diagnosis.jpg</a></li> @endif
                        @if($record->recipient_photo) <li><a href="{{ Storage::url($record->recipient_photo) }}" target="_blank">recipient-photo.jpg</a></li> @endif
                    @endif
                </ul>
            </section>
        </div>
    </article>

    <article class="staff-block">
        <h2>Verification Decision</h2>
        <form class="verification-form" data-verification-form data-action-url="{{ route('staff.verification.status', ['type' => $type, 'reference' => $reference]) }}" novalidate>
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
