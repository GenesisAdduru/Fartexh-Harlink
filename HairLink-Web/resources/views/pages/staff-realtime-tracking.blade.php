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
            <div class="batch-line">
                <strong>Recipient Trackers</strong>
                <span>{{ $requests->count() }} active trackers</span>
            </div>
            @forelse($requests as $request)
                @php
                    $normStatus = str_replace(' ', '-', strtolower($request->status));
                @endphp
                <article class="tracking-item" data-track-card data-card-id="{{ $request->reference }}" data-current-status="{{ $normStatus }}" data-card-type="recipient">
                    <div class="tracking-head">
                        <strong>Request # {{ $request->reference }}</strong>
                        <span class="status-chip" data-status-chip>{{ $request->status }}</span>
                    </div>
                    <div class="tracking-meta">
                        <span>{{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}</span>
                        <span>{{ $request->wig_length }}</span>
                        <span>{{ $request->wig_color }}</span>
                    </div>
                    <div class="stage-row">
                        <div class="stage" data-stage="validated"><i class='bx bx-check-circle'></i><small>Validated</small></div>
                        <div class="stage" data-stage="matched"><i class='bx bx-user-check'></i><small>Matched</small></div>
                        <div class="stage" data-stage="in-transit"><i class='bx bx-bus'></i><small>In Transit</small></div>
                        <div class="stage" data-stage="completed"><i class='bx bx-check-double'></i><small>Completed</small></div>
                    </div>
                    <div class="track-actions">
                        <button type="button" class="soft-btn" data-move-next>Advance Status ></button>
                    </div>
                    <div class="progress-editor">
                        <div class="progress-editor-row">
                            <select data-manual-status>
                                <option value="validated" @selected($normStatus === 'validated')>Validated</option>
                                <option value="matched" @selected($normStatus === 'matched')>Matched</option>
                                <option value="in-transit" @selected($normStatus === 'in-transit')>In Transit</option>
                                <option value="completed" @selected($normStatus === 'completed')>Completed</option>
                            </select>
                            <label><input type="checkbox" data-issue-toggle> Mark as issue</label>
                            <button type="button" class="ghost-btn" data-save-edit>Save Edit</button>
                        </div>
                        <p class="edit-banner" data-edit-banner hidden></p>
                    </div>
                    <p class="tracking-footnote" data-last-updated>Last updated: {{ $request->updated_at->diffForHumans() }}</p>
                </article>
            @empty
                <div style="padding: 1rem; color: #665772;">No recipient requests currently in tracking.</div>
            @endforelse

            <div class="batch-line" style="margin-top: 2rem;">
                <strong>Donation Trackers</strong>
                <span>{{ $donations->count() }} active trackers</span>
            </div>
            @forelse($donations as $donation)
                @php
                    $normStatus = str_replace(' ', '-', strtolower($donation->status));
                @endphp
                <article class="tracking-item" data-track-card data-card-id="{{ $donation->reference }}" data-current-status="{{ $normStatus }}" data-card-type="donor">
                    <div class="tracking-head">
                        <strong>Donation # {{ $donation->reference }}</strong>
                        <span class="status-chip" data-status-chip>{{ $donation->status }}</span>
                    </div>
                    <div class="tracking-meta">
                        <span>{{ $donation->user->first_name ?? '' }} {{ $donation->user->last_name ?? '' }}</span>
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
