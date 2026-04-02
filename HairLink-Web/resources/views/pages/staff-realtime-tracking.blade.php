@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Real-time Tracking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <div class="section-title-block">
        <h1>Real-time Staff and Partner Wigmaker Tracking</h1>
        <p>Track each donation batch assigned to partner wigmakers and move workflow stages.</p>
    </div>

    <article class="staff-block">
        <div class="staff-bar">
            <div class="batch-line">
                <strong>Inventory Live Feed</strong>
                <span>{{ $donations->count() }} active trackers</span>
            </div>
            <a class="soft-btn" href="{{ route('staff.wig-stock') }}">Add Wig</a>
        </div>

        <div class="tracking-grid">
            @forelse($donations as $donation)
                @php
                    $normStatus = str_replace(' ', '-', strtolower($donation->status));
                @endphp
                <article class="tracking-item" data-track-card data-card-id="{{ $donation->reference }}" data-current-status="{{ $normStatus }}">
                    <div class="tracking-head">
                        <strong>Donation # {{ $donation->reference }}</strong>
                        <span class="status-chip" data-status-chip>{{ $donation->status }}</span>
                    </div>
                    <div class="tracking-meta">
                        <span>{{ $donation->created_at->format('M d, Y') }}</span>
                        <span>{{ $donation->hair_length }}</span>
                        <span>{{ $donation->hair_color }}</span>
                    </div>
                    <div class="stage-row">
                        <div class="stage" data-stage="received"><i class='bx bx-package'></i><small>Received</small></div>
                        <div class="stage" data-stage="in-queue"><i class='bx bx-time-five'></i><small>In Queue</small></div>
                        <div class="stage" data-stage="in-progress"><i class='bx bxs-star'></i><small>In Progress</small></div>
                        <div class="stage" data-stage="completed"><i class='bx bx-heart'></i><small>Completed</small></div>
                    </div>
                    <div class="track-actions">
                        <button type="button" class="soft-btn" data-move-next>Advance Status ></button>
                    </div>
                    <div class="progress-editor">
                        <div class="progress-editor-row">
                            <select data-manual-status>
                                <option value="received" @selected($normStatus === 'received')>Received</option>
                                <option value="in-queue" @selected($normStatus === 'in-queue')>In Queue</option>
                                <option value="in-progress" @selected($normStatus === 'in-progress')>In Progress</option>
                                <option value="completed" @selected($normStatus === 'completed')>Completed</option>
                            </select>
                            <label><input type="checkbox" data-issue-toggle> Mark as issue</label>
                            <button type="button" class="ghost-btn" data-save-edit>Save Edit</button>
                        </div>
                        <div class="issue-wrap" data-issue-wrap hidden>
                            <textarea rows="2" placeholder="Describe the issue and action needed..." data-issue-note></textarea>
                        </div>
                        <p class="edit-banner" data-edit-banner hidden></p>
                    </div>
                    <p class="tracking-footnote" data-last-updated>Last updated: {{ $donation->updated_at->diffForHumans() }}</p>
                </article>
            @empty
                <div style="padding: 1rem; color: #665772;">No donations currently in the tracking workflow.</div>
            @endforelse
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
