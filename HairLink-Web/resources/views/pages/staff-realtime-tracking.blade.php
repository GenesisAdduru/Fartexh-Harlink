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
                <strong>Batch # 5</strong>
                <span></span>
            </div>
            <a class="soft-btn" href="{{ route('staff.wig-stock') }}">Add Wig</a>
        </div>

        <div class="tracking-grid">
            <article class="tracking-item" data-track-card data-card-id="A101" data-current-status="received">
                <div class="tracking-head">
                    <strong>Donation # A101</strong>
                    <span class="status-chip" data-status-chip>Received</span>
                </div>
                <div class="tracking-meta"><span>Feb 25, 2024</span><span>Short</span><span>Black</span></div>
                <div class="stage-row">
                    <div class="stage" data-stage="received"><i class='bx bx-package'></i><small>Received</small></div>
                    <div class="stage" data-stage="in-queue"><i class='bx bx-time-five'></i><small>In Queue</small></div>
                    <div class="stage" data-stage="in-progress"><i class='bx bxs-star'></i><small>In Progress</small></div>
                    <div class="stage" data-stage="completed"><i class='bx bx-heart'></i><small>Completed</small></div>
                </div>
                <div class="track-actions"><button type="button" class="soft-btn" data-move-next>Move to In Queue ></button></div>
                <div class="progress-editor">
                    <div class="progress-editor-row">
                        <select data-manual-status>
                            <option value="received">Received</option>
                            <option value="in-queue">In Queue</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <label><input type="checkbox" data-issue-toggle> Mark as issue</label>
                        <button type="button" class="ghost-btn" data-save-edit>Save Edit</button>
                    </div>
                    <div class="issue-wrap" data-issue-wrap hidden>
                        <textarea rows="2" placeholder="Describe the issue and action needed..." data-issue-note></textarea>
                    </div>
                    <p class="edit-banner" data-edit-banner hidden></p>
                </div>
                <p class="tracking-footnote" data-last-updated>Last updated: Not yet updated</p>
            </article>

            <article class="tracking-item" data-track-card data-card-id="A102" data-current-status="in-queue">
                <div class="tracking-head"><strong>Donation # A102</strong><span class="status-chip" data-status-chip>In Queue</span></div>
                <div class="tracking-meta"><span>Feb 25, 2024</span><span>Short</span><span>Brown</span></div>
                <div class="stage-row">
                    <div class="stage" data-stage="received"><i class='bx bx-package'></i><small>Received</small></div>
                    <div class="stage" data-stage="in-queue"><i class='bx bx-time-five'></i><small>In Queue</small></div>
                    <div class="stage" data-stage="in-progress"><i class='bx bxs-star'></i><small>In Progress</small></div>
                    <div class="stage" data-stage="completed"><i class='bx bx-heart'></i><small>Completed</small></div>
                </div>
                <div class="track-actions"><button type="button" class="soft-btn" data-move-next>Move to In Progress ></button></div>
                <div class="progress-editor">
                    <div class="progress-editor-row">
                        <select data-manual-status>
                            <option value="received">Received</option>
                            <option value="in-queue">In Queue</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <label><input type="checkbox" data-issue-toggle> Mark as issue</label>
                        <button type="button" class="ghost-btn" data-save-edit>Save Edit</button>
                    </div>
                    <div class="issue-wrap" data-issue-wrap hidden>
                        <textarea rows="2" placeholder="Describe the issue and action needed..." data-issue-note></textarea>
                    </div>
                    <p class="edit-banner" data-edit-banner hidden></p>
                </div>
                <p class="tracking-footnote" data-last-updated>Last updated: Not yet updated</p>
            </article>

            <article class="tracking-item" data-track-card data-card-id="A103" data-current-status="in-progress">
                <div class="tracking-head"><strong>Donation # A103</strong><span class="status-chip" data-status-chip>In Progress</span></div>
                <div class="tracking-meta"><span>Feb 25, 2024</span><span>Long</span><span>Brown</span></div>
                <div class="stage-row">
                    <div class="stage" data-stage="received"><i class='bx bx-package'></i><small>Received</small></div>
                    <div class="stage" data-stage="in-queue"><i class='bx bx-time-five'></i><small>In Queue</small></div>
                    <div class="stage" data-stage="in-progress"><i class='bx bxs-star'></i><small>In Progress</small></div>
                    <div class="stage" data-stage="completed"><i class='bx bx-heart'></i><small>Completed</small></div>
                </div>
                <div class="track-actions"><button type="button" class="soft-btn" data-move-next>Move to Completed ></button></div>
                <div class="progress-editor">
                    <div class="progress-editor-row">
                        <select data-manual-status>
                            <option value="received">Received</option>
                            <option value="in-queue">In Queue</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <label><input type="checkbox" data-issue-toggle> Mark as issue</label>
                        <button type="button" class="ghost-btn" data-save-edit>Save Edit</button>
                    </div>
                    <div class="issue-wrap" data-issue-wrap hidden>
                        <textarea rows="2" placeholder="Describe the issue and action needed..." data-issue-note></textarea>
                    </div>
                    <p class="edit-banner" data-edit-banner hidden></p>
                </div>
                <p class="tracking-footnote" data-last-updated>Last updated: Not yet updated</p>
            </article>

            <article class="tracking-item" data-track-card data-card-id="A104" data-current-status="completed">
                <div class="tracking-head"><strong>Donation # A104</strong><span class="status-chip" data-status-chip>Completed</span></div>
                <div class="tracking-meta"><span>Feb 25, 2024</span><span>Long</span><span>Light</span></div>
                <div class="stage-row">
                    <div class="stage" data-stage="received"><i class='bx bx-package'></i><small>Received</small></div>
                    <div class="stage" data-stage="in-queue"><i class='bx bx-time-five'></i><small>In Queue</small></div>
                    <div class="stage" data-stage="in-progress"><i class='bx bxs-star'></i><small>In Progress</small></div>
                    <div class="stage" data-stage="completed"><i class='bx bx-heart'></i><small>Completed</small></div>
                </div>
                <div class="track-actions"><button type="button" class="soft-btn" data-move-next hidden>Move to Completed ></button></div>
                <div class="progress-editor">
                    <div class="progress-editor-row">
                        <select data-manual-status>
                            <option value="received">Received</option>
                            <option value="in-queue">In Queue</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <label><input type="checkbox" data-issue-toggle> Mark as issue</label>
                        <button type="button" class="ghost-btn" data-save-edit>Save Edit</button>
                    </div>
                    <div class="issue-wrap" data-issue-wrap hidden>
                        <textarea rows="2" placeholder="Describe the issue and action needed..." data-issue-note></textarea>
                    </div>
                    <p class="edit-banner" data-edit-banner hidden></p>
                </div>
                <p class="tracking-footnote" data-last-updated>Last updated: Not yet updated</p>
            </article>
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
