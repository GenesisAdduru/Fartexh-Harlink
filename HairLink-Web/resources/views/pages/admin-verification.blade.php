@extends('layouts.dashboard')

@section('title', 'HairLink | Admin Verification Oversight')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">
    <header class="admin-page-head">
        <p class="admin-page-kicker">Admin · Verification Oversight</p>
        <h1>Donor and Recipient Review Queue</h1>
        <p>Monitor approvals, exceptions, and records that still need final admin validation.</p>
    </header>

    <div class="inv-summary-grid">
        <div class="inv-summary-item">
            <span>Donor Pending</span>
            <strong>8</strong>
        </div>
        <div class="inv-summary-item">
            <span>Recipient Pending</span>
            <strong>5</strong>
        </div>
        <div class="inv-summary-item">
            <span>Approved Today</span>
            <strong>11</strong>
        </div>
        <div class="inv-summary-item">
            <span>Flagged Cases</span>
            <strong>3</strong>
        </div>
    </div>

    <div class="admin-grid-two">
        <article class="admin-card">
            <div class="admin-card-head admin-card-head-stack">
                <div>
                    <p class="admin-section-kicker">Donor Review</p>
                    <h2><i class='bx bx-transfer-alt'></i> Donor Hair Verification</h2>
                </div>
                <span>Incoming donation records</span>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0003 · Linda Cruz</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Short hair · Light · Submission photos need quality confirmation.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.verification.detail', ['type' => 'donor', 'reference' => 'HD-0003']) }}">Open</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0008 · Sofia Tan</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Medium hair · Light · Waiting for final cleanliness check.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.verification.detail', ['type' => 'donor', 'reference' => 'HD-0008']) }}">Open</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0011 · Grace Navarro</strong>
                            <span class="admin-chip rejected">Needs Review</span>
                        </div>
                        <p>Long hair · Brown · Staff requested admin override on decision.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.verification.detail', ['type' => 'donor', 'reference' => 'HD-0011']) }}">Open</a>
                </article>
            </div>
        </article>

        <article class="admin-card">
            <div class="admin-card-head admin-card-head-stack">
                <div>
                    <p class="admin-section-kicker">Recipient Review</p>
                    <h2><i class='bx bx-user-check'></i> Recipient Request Verification</h2>
                </div>
                <span>Medical and wig request approvals</span>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0002 · Linda Cruz</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Short wig · Brown · Waiting for medical certificate verification.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.verification.detail', ['type' => 'recipient', 'reference' => 'RR-0002']) }}">Open</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0004 · Sofia Tan</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Medium wig · Light · Medical documents under manual review.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.verification.detail', ['type' => 'recipient', 'reference' => 'RR-0004']) }}">Open</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0010 · Marites Ramos</strong>
                            <span class="admin-chip approved">Approved</span>
                        </div>
                        <p>Long wig · Black · Ready to move into matching workflow.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.verification.detail', ['type' => 'recipient', 'reference' => 'RR-0010']) }}">Open</a>
                </article>
            </div>
        </article>
    </div>

    <article class="admin-card" data-admin-search-block>
        <div class="admin-bar">
            <div>
                <p class="admin-section-kicker">Audit Trail</p>
                <h2><i class='bx bx-list-ul'></i> Verification Activity Log</h2>
            </div>
            <div class="admin-tools">
                <input type="text" placeholder="Search reference or person..." data-admin-search-input aria-label="Search verification activity">
                <button class="soft-btn" type="button" data-admin-search-btn>Search</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Person</th>
                        <th>Type</th>
                        <th>Latest Action</th>
                        <th>Owner</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-admin-search-row><td>HD-0003</td><td>Linda Cruz</td><td>Donor</td><td>Awaiting hair quality validation</td><td>Admin</td><td><span class="admin-chip pending">Pending</span></td></tr>
                    <tr data-admin-search-row><td>RR-0002</td><td>Linda Cruz</td><td>Recipient</td><td>Medical certificate queued</td><td>Admin</td><td><span class="admin-chip pending">Pending</span></td></tr>
                    <tr data-admin-search-row><td>HD-0011</td><td>Grace Navarro</td><td>Donor</td><td>Appeal for rejection review</td><td>Supervisor</td><td><span class="admin-chip rejected">Escalated</span></td></tr>
                    <tr data-admin-search-row><td>RR-0010</td><td>Marites Ramos</td><td>Recipient</td><td>Cleared for matching</td><td>Admin</td><td><span class="admin-chip approved">Approved</span></td></tr>
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush