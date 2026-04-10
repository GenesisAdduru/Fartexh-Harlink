@extends('layouts.dashboard')

@section('title', 'HairLink | Tracking Detail')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/donor-module.css') }}">
@endpush

@section('content')
    <section class="section-wrap donor-module-page reveal" id="trackingDetailRoot">
        <header class="module-head">
            <h1>Donation Tracking Detail</h1>
            <p>Reference: <strong>{{ $donation->reference }}</strong></p>
            <div class="action-row">
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">Back to Tracking List</a>
            </div>
        </header>

        <article class="module-card">
            <div class="summary-grid">
                <div class="summary-item">
                    <small>Current Status</small>
                    <strong>{{ $donation->status }}</strong>
                    <div class="demo-row">
                        <span class="status-pill status-{{ strtolower($donation->status) }}">{{ $donation->status }}</span>
                    </div>
                </div>
                <div class="summary-item">
                    <small>Submitted On</small>
                    <strong>{{ $donation->created_at->format('Y-m-d') }}</strong>
                </div>
                <div class="summary-item">
                    <small>Donor</small>
                    <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>
                </div>
                <div class="summary-item">
                    <small>Hair Details</small>
                    <strong>{{ $donation->hair_length }} / {{ $donation->hair_color }}</strong>
                </div>
            </div>

            <div class="note-box">
                Track each milestone below. Certificate becomes available once status reaches Completed.
            </div>
        </article>

        <article class="module-card">
            <h2>Donation Timeline</h2>
            <ul class="timeline" id="detailTimeline">
                @forelse($donation->statusHistories()->orderBy('created_at', 'desc')->get() as $history)
                <li class="timeline-item">
                    <div class="timeline-meta">
                        <strong>{{ $history->status }}</strong>
                        <small>{{ $history->created_at->format('M d, Y H:i') }}</small>
                    </div>
                    <div class="timeline-desc">
                        {{ $history->notes ?? 'Status changed to ' . $history->status }}
                    </div>
                </li>
                @empty
                <li class="timeline-item">
                    <div class="timeline-meta">
                        <strong>Submitted</strong>
                        <small>{{ $donation->created_at->format('M d, Y H:i') }}</small>
                    </div>
                    <div class="timeline-desc">
                        Donation record received and queued for physical delivery.
                    </div>
                </li>
                @endforelse
            </ul>
            @if(in_array($donation->status, ['Verified', 'Completed']))
            <div class="action-row">
                <a class="soft-btn" href="{{ route('donor.certificate') }}">Open Certificate</a>
            </div>
            @endif
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-module.js') }}" defer></script>
@endpush
