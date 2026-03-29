@extends('layouts.dashboard')

@section('title', 'HairLink | Admin Operations Overview')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">
    <header class="admin-page-head">
        <p class="admin-page-kicker">Admin · Operations Overview</p>
        <h1>System Operations Overview</h1>
        <p>Monitor staff verification flow, wigmaker production progress, delivery movement, and stock readiness.</p>
    </header>

    <div class="inv-summary-grid">
        <div class="inv-summary-item">
            <span>Staff Active</span>
            <strong>6</strong>
        </div>
        <div class="inv-summary-item">
            <span>Wigmaker Tasks</span>
            <strong>14</strong>
        </div>
        <div class="inv-summary-item">
            <span>In Transit Batches</span>
            <strong>2</strong>
        </div>
        <div class="inv-summary-item">
            <span>Completed Wigs</span>
            <strong>39</strong>
        </div>
    </div>

    <div class="admin-grid-two">
        <article class="admin-card">
            <div class="admin-card-head admin-card-head-stack">
                <div>
                    <p class="admin-section-kicker">Staff Workflow</p>
                    <h2><i class='bx bx-briefcase-alt-2'></i> Operations Snapshot</h2>
                </div>
                <span>Verification and release handling</span>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>Verification Desk</strong>
                            <span class="admin-chip approved">Stable</span>
                        </div>
                        <p>13 total queue items, 5 still waiting for admin review.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.verification') }}">Open</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>Recipient Release</strong>
                            <span class="admin-chip pending">Monitor</span>
                        </div>
                        <p>3 allocations require final release scheduling this week.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.matching') }}">Open</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>Inventory Intake</strong>
                            <span class="admin-chip available">On Track</span>
                        </div>
                        <p>Hair stock updates are synchronized with approved donor records.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.inventory') }}">Open</a>
                </article>
            </div>
        </article>

        <article class="admin-card">
            <div class="admin-card-head admin-card-head-stack">
                <div>
                    <p class="admin-section-kicker">Wigmaker Network</p>
                    <h2><i class='bx bx-cog'></i> Production Snapshot</h2>
                </div>
                <span>Batch progress and delivery status</span>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>Batch 004 · Reyes Wig Studio</strong>
                            <span class="admin-chip transit">In Transit</span>
                        </div>
                        <p>3 wigs dispatched Mar 25, expected arrival Mar 29.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.delivery-batches') }}">Track</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>A104 · Hand-finishing</strong>
                            <span class="admin-chip pending">In Progress</span>
                        </div>
                        <p>Quality review remarks submitted by staff for next stage update.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('staff.realtime-tracking') }}">Track</a>
                </article>
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>Batch 003 · Reyes Wig Studio</strong>
                            <span class="admin-chip arrived">Delivered</span>
                        </div>
                        <p>4 wigs stocked and available for recipient allocation.</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.inventory') }}">Track</a>
                </article>
            </div>
        </article>
    </div>

    <article class="admin-card" data-admin-search-block>
        <div class="admin-bar">
            <div>
                <p class="admin-section-kicker">System Activity</p>
                <h2><i class='bx bx-table'></i> Operations Monitor</h2>
            </div>
            <div class="admin-tools">
                <input type="text" placeholder="Search team, batch, or module..." data-admin-search-input aria-label="Search operations monitor">
                <button class="soft-btn" type="button" data-admin-search-btn>Search</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Area</th>
                        <th>Owner</th>
                        <th>Current Load</th>
                        <th>Latest Update</th>
                        <th>Attention</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-admin-search-row><td>Donor Verification</td><td>Staff Desk</td><td>8 pending</td><td>2 approvals in last hour</td><td><span class="admin-chip pending">Review Queue</span></td></tr>
                    <tr data-admin-search-row><td>Recipient Verification</td><td>Staff Desk</td><td>5 pending</td><td>1 case awaiting medical recheck</td><td><span class="admin-chip pending">Needs Review</span></td></tr>
                    <tr data-admin-search-row><td>Wigmaker Tracking</td><td>Reyes Wig Studio</td><td>14 active tasks</td><td>A104 flagged during finishing</td><td><span class="admin-chip rejected">Issue Flag</span></td></tr>
                    <tr data-admin-search-row><td>Delivery Batches</td><td>Dispatch Team</td><td>2 in transit</td><td>Batch 004 due today</td><td><span class="admin-chip transit">Monitor</span></td></tr>
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush