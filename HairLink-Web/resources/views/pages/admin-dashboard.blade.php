@extends('layouts.dashboard')

@section('title', 'HairLink | Admin Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">

    <header class="admin-hero admin-surface">
        <div class="admin-hero-copy">
            <p class="admin-kicker">Administrative Dashboard</p>
            <h1>Admin Overview</h1>
            <p>Monitor donor and recipient workflows, approvals, and operational activity from one clear workspace.</p>
        </div>

        <aside class="admin-hero-side">
            <div class="admin-hero-badge">
                <i class='bx bxs-shield-alt-2'></i>
                <span>Admin View</span>
            </div>

            <div class="admin-hero-summary">
                <div>
                    <strong>Next priority</strong>
                    <span>5 records awaiting review</span>
                </div>
                <a class="admin-quick-btn admin-quick-btn-primary" href="{{ route('admin.verification') }}">
                    <i class='bx bx-right-arrow-alt'></i> Open Review Queue
                </a>
            </div>
        </aside>
    </header>

    <section class="admin-stat-grid">
        <article class="admin-stat admin-stat-donor">
            <span class="admin-stat-accent"></span>
            <div class="admin-stat-label">
                <i class='bx bx-transfer-alt'></i>
                <span>Donor Submissions</span>
            </div>
            <h2>{{ $donationsCount }}</h2>
            <p>Total hair donations recorded</p>
        </article>

        <article class="admin-stat admin-stat-approved">
            <span class="admin-stat-accent"></span>
            <div class="admin-stat-label">
                <i class='bx bx-check-circle'></i>
                <span>Registered Users</span>
            </div>
            <h2>{{ $usersCount }}</h2>
            <p>Total users in the system</p>
        </article>

        <article class="admin-stat admin-stat-recipient">
            <span class="admin-stat-accent"></span>
            <div class="admin-stat-label">
                <i class='bx bx-user-check'></i>
                <span>Recipient Requests</span>
            </div>
            <h2>{{ $requestsCount }}</h2>
            <p>Requests submitted through the portal</p>
        </article>

        <article class="admin-stat admin-stat-pending">
            <span class="admin-stat-accent"></span>
            <div class="admin-stat-label">
                <i class='bx bx-time-five'></i>
                <span>Pending Review</span>
            </div>
            <h2>{{ $pendingVerifications }}</h2>
            <p>Requires immediate admin decision</p>
        </article>
    </section>

    <div class="admin-toolbar admin-surface">
        <div class="admin-toolbar-copy">
            <h2>Quick Actions</h2>
            <p>Use the most common admin tasks without leaving the dashboard.</p>
        </div>
        <div class="admin-quick-actions">
            <a class="admin-quick-btn" href="{{ route('admin.verification') }}">
                <i class='bx bx-check-shield'></i> Review Verification
            </a>
            <a class="admin-quick-btn" href="{{ route('admin.matching') }}">
                <i class='bx bx-sort-alt-2'></i> Review Matching
            </a>
            <a class="admin-quick-btn" href="{{ route('admin.inventory') }}">
                <i class='bx bx-cube'></i> Check Inventory
            </a>
            <a class="admin-quick-btn" href="{{ route('admin.operations') }}">
                <i class='bx bx-pulse'></i> View Operations
            </a>
        </div>
    </div>

    <section class="admin-priority-grid">
        <article class="admin-focus-card admin-focus-donor">
            <div class="admin-focus-head">
                <div>
                    <p class="admin-section-kicker">Priority Queue</p>
                    <h2><i class='bx bx-transfer-alt'></i> Donor Submissions</h2>
                </div>
                <a class="admin-review-link" href="{{ route('admin.verification') }}">View all</a>
            </div>

            <div class="admin-focus-summary">
                <div class="admin-mini-stat">
                    <strong>68</strong>
                    <span>Approved</span>
                </div>
                <div class="admin-mini-stat">
                    <strong>8</strong>
                    <span>Pending</span>
                </div>
                <div class="admin-mini-stat">
                    <strong>3</strong>
                    <span>Rejected</span>
                </div>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0001 · Maria Santos</strong>
                            <span class="admin-chip approved">Approved</span>
                        </div>
                        <p>Long hair · Black · Submitted Mar 28, 2026</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.verification') }}">Review</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0003 · Linda Cruz</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Short hair · Light · Needs final validation</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.verification') }}">Review</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0004 · Ana Reyes</strong>
                            <span class="admin-chip approved">Approved</span>
                        </div>
                        <p>Long hair · Brown · Stock-ready after intake</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.verification') }}">Review</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>HD-0005 · Roberto Lim</strong>
                            <span class="admin-chip rejected">Rejected</span>
                        </div>
                        <p>Medium hair · Black · Rejected due to quality mismatch</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.verification') }}">Review</a>
                </article>
            </div>
        </article>

        <article class="admin-focus-card admin-focus-recipient">
            <div class="admin-focus-head">
                <div>
                    <p class="admin-section-kicker">Priority Queue</p>
                    <h2><i class='bx bx-user-check'></i> Recipient Requests</h2>
                </div>
                <a class="admin-review-link" href="{{ route('admin.matching') }}">View all</a>
            </div>

            <div class="admin-focus-summary">
                <div class="admin-mini-stat">
                    <strong>21</strong>
                    <span>Approved</span>
                </div>
                <div class="admin-mini-stat">
                    <strong>5</strong>
                    <span>Pending</span>
                </div>
                <div class="admin-mini-stat">
                    <strong>5</strong>
                    <span>Needs Match</span>
                </div>
            </div>

            <div class="admin-queue-list">
                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0001 · Ana Reyes</strong>
                            <span class="admin-chip approved">Approved</span>
                        </div>
                        <p>Medium wig · Black · Ready for matching workflow</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.matching') }}">Review</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0002 · Linda Cruz</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Short wig · Brown · Waiting for admin approval</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.matching') }}">Review</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0003 · Carmen Torres</strong>
                            <span class="admin-chip approved">Approved</span>
                        </div>
                        <p>Long wig · Black · Waiting for stock allocation</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.matching') }}">Review</a>
                </article>

                <article class="admin-queue-item">
                    <div class="admin-queue-main">
                        <div class="admin-queue-title-row">
                            <strong>RR-0004 · Sofia Tan</strong>
                            <span class="admin-chip pending">Pending</span>
                        </div>
                        <p>Medium wig · Light · Medical documents under checking</p>
                    </div>
                    <a class="admin-row-link" href="{{ route('admin.matching') }}">Review</a>
                </article>
            </div>
        </article>
    </section>

    <article class="admin-card admin-module-panel">
        <div class="admin-card-head admin-card-head-stack">
            <div>
                <p class="admin-section-kicker">Workspace</p>
                <h2><i class='bx bxs-dashboard'></i> Module Access</h2>
            </div>
            <span>Jump to the area you need</span>
        </div>

        <div class="admin-actions admin-actions-module">
            <a class="admin-action-link admin-action-link-strong" href="{{ route('admin.users') }}">
                <div class="admin-action-icon"><i class='bx bx-group'></i></div>
                <div>
                    <h3>User Management</h3>
                    <p>Manage donors, recipients, staff, and wigmakers.</p>
                </div>
            </a>
            <a class="admin-action-link admin-action-link-strong" href="{{ route('admin.verification') }}">
                <div class="admin-action-icon"><i class='bx bx-check-shield'></i></div>
                <div>
                    <h3>Verification Oversight</h3>
                    <p>Review donor and recipient approval queues in one place.</p>
                </div>
            </a>
            <a class="admin-action-link admin-action-link-strong" href="{{ route('admin.matching') }}">
                <div class="admin-action-icon"><i class='bx bx-sort-alt-2'></i></div>
                <div>
                    <h3>Matching Oversight</h3>
                    <p>Track allocation readiness and final wig matching decisions.</p>
                </div>
            </a>
            <a class="admin-action-link" href="{{ route('admin.operations') }}">
                <div class="admin-action-icon"><i class='bx bx-pulse'></i></div>
                <div>
                    <h3>Operations Overview</h3>
                    <p>Watch staff, wigmaker, delivery, and stock movement at system level.</p>
                </div>
            </a>
            <a class="admin-action-link" href="{{ route('admin.inventory') }}">
                <div class="admin-action-icon"><i class='bx bx-cube'></i></div>
                <div>
                    <h3>Inventory Overview</h3>
                    <p>Review hair stock, wig stock, and delivery records.</p>
                </div>
            </a>
            <a class="admin-action-link" href="{{ route('admin.reports') }}">
                <div class="admin-action-icon"><i class='bx bx-file-blank'></i></div>
                <div>
                    <h3>Reports</h3>
                    <p>Open donation, production, and distribution summaries.</p>
                </div>
            </a>
            <a class="admin-action-link" href="{{ route('admin.events') }}">
                <div class="admin-action-icon"><i class='bx bx-calendar-event'></i></div>
                <div>
                    <h3>Events</h3>
                    <p>Schedule public activities and donation drives.</p>
                </div>
            </a>
            <a class="admin-action-link" href="{{ route('admin.community') }}">
                <div class="admin-action-icon"><i class='bx bxs-megaphone'></i></div>
                <div>
                    <h3>Community Forum</h3>
                    <p>Moderate announcements, posts, and discussions.</p>
                </div>
            </a>
        </div>
    </article>

    <div class="admin-optional" data-optional-section>
        <div class="admin-optional-head" data-optional-toggle>
            <h2><i class='bx bx-donate-heart'></i> Monetary Donations</h2>
            <div class="admin-optional-meta">
                <span class="admin-optional-tag">Optional</span>
                <i class='bx bx-chevron-down' data-optional-chevron></i>
            </div>
        </div>

        <div class="admin-optional-body" data-optional-body hidden>
            <div class="table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date and Time</th>
                            <th>Email</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Maria Santos</td>
                            <td>Mar 28, 2026 · 09:14 AM</td>
                            <td>m.santos@email.com</td>
                            <td>₱500.00</td>
                        </tr>
                        <tr>
                            <td>Jose Dela Cruz</td>
                            <td>Mar 27, 2026 · 03:42 PM</td>
                            <td>jdelacruz@mail.com</td>
                            <td>₱1,000.00</td>
                        </tr>
                        <tr>
                            <td>Ana Reyes</td>
                            <td>Mar 27, 2026 · 11:05 AM</td>
                            <td>ana.reyes@gmail.com</td>
                            <td>₱250.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush
