@extends('layouts.dashboard')

@section('title', 'HairLink | Admin Matching Oversight')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">
    <header class="admin-page-head">
        <p class="admin-page-kicker">Admin · Matching Oversight</p>
        <h1>Matching and Allocation Monitoring</h1>
        <p>Review matching readiness, allocation priorities, and release-stage exceptions for recipients.</p>
    </header>

    <div class="inv-summary-grid">
        <div class="inv-summary-item">
            <span>Ready to Match</span>
            <strong>5</strong>
        </div>
        <div class="inv-summary-item">
            <span>Allocated Wigs</span>
            <strong>12</strong>
        </div>
        <div class="inv-summary-item">
            <span>High Match Score</span>
            <strong>92%</strong>
        </div>
        <div class="inv-summary-item">
            <span>Hold Cases</span>
            <strong>2</strong>
        </div>
    </div>

    <div class="admin-grid-two">
        <article class="admin-card">
            <div class="admin-card-head admin-card-head-stack">
                <div>
                    <p class="admin-section-kicker">Readiness</p>
                    <h2><i class='bx bx-sort-alt-2'></i> Matching Queue</h2>
                </div>
                <span>Verified recipients waiting for best-fit wigs</span>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0010 · Marites Ramos</strong>
                            <span class="admin-chip approved">Ready</span>
                        </div>
                        <p>Preferred: Long · Black · Top match available: A110 at 92%.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.rule-matching') }}">Review</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0001 · Ana Reyes</strong>
                            <span class="admin-chip approved">Ready</span>
                        </div>
                        <p>Preferred: Medium · Black · Allocation waiting for confirmation.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.rule-matching') }}">Review</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0003 · Carmen Torres</strong>
                            <span class="admin-chip pending">On Hold</span>
                        </div>
                        <p>Long · Black · Inventory available but release documents incomplete.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.recipient-matching-list') }}">Review</a>
                </article>
            </div>
        </article>

        <article class="admin-card">
            <div class="admin-card-head admin-card-head-stack">
                <div>
                    <p class="admin-section-kicker">Allocation</p>
                    <h2><i class='bx bx-package'></i> Wig Release Status</h2>
                </div>
                <span>Current matching outcomes</span>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>A109 → RR-0006</strong>
                            <span class="admin-chip allocated">Allocated</span>
                        </div>
                        <p>Medium · Brown · Release appointment booked for Apr 02.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.recipient-matching-list') }}">Track</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>A110 → RR-0010</strong>
                            <span class="admin-chip available">Candidate</span>
                        </div>
                        <p>Long · Black · Highest current score for recipient request.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.rule-matching') }}">Track</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>A108 → RR-0009</strong>
                            <span class="admin-chip pending">Review</span>
                        </div>
                        <p>Short · Light · Color approval pending before release.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.recipient-matching-list') }}">Track</a>
                </article>
            </div>
        </article>
    </div>

    <article class="admin-card" data-admin-search-block>
        <div class="admin-bar">
            <div>
                <p class="admin-section-kicker">Overview</p>
                <h2><i class='bx bx-spreadsheet'></i> Matching Pipeline</h2>
            </div>
            <div class="admin-tools">
                <input type="text" placeholder="Search recipient or stock..." data-admin-search-input aria-label="Search matching pipeline">
                <button class="soft-btn" type="button" data-admin-search-btn>Search</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Recipient Ref</th>
                        <th>Recipient</th>
                        <th>Preferred Wig</th>
                        <th>Best Current Match</th>
                        <th>Score</th>
                        <th>Stage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-admin-search-row><td>RR-0010</td><td>Marites Ramos</td><td>Long · Black</td><td>A110</td><td>92%</td><td><span class="admin-chip approved">Ready</span></td></tr>
                    <tr data-admin-search-row><td>RR-0001</td><td>Ana Reyes</td><td>Medium · Black</td><td>A107</td><td>88%</td><td><span class="admin-chip pending">For Allocation</span></td></tr>
                    <tr data-admin-search-row><td>RR-0003</td><td>Carmen Torres</td><td>Long · Black</td><td>A103</td><td>84%</td><td><span class="admin-chip pending">On Hold</span></td></tr>
                    <tr data-admin-search-row><td>RR-0009</td><td>Melissa Ong</td><td>Short · Light</td><td>A108</td><td>86%</td><td><span class="admin-chip allocated">Allocated</span></td></tr>
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush