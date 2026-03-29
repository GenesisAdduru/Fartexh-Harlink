@extends('layouts.dashboard')

@section('title', 'HairLink | Admin Reports')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">

    <header style="padding:0.6rem 0 0.2rem">
        <p style="font-size:0.72rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#9b2f69;margin-bottom:0.2rem;">Admin · Reports</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.1rem);color:#261d2b;">Reports</h1>
        <p style="color:#665772;font-size:0.88rem;margin-top:0.25rem;">System-wide summary data and downloadable reports.</p>
    </header>

    {{-- KPI overview --}}
    <div class="inv-summary-grid">
        <div class="inv-summary-item">
            <span>Total Donations</span>
            <strong>13.5K</strong>
        </div>
        <div class="inv-summary-item">
            <span>Hair Received</span>
            <strong>79</strong>
        </div>
        <div class="inv-summary-item">
            <span>Wigs Distributed</span>
            <strong>34</strong>
        </div>
        <div class="inv-summary-item">
            <span>Recipients Served</span>
            <strong>28</strong>
        </div>
    </div>

    {{-- Report cards --}}
    <article class="admin-card">
        <div class="admin-card-head">
            <h2><i class='bx bx-file-blank'></i> Downloadable Reports</h2>
            <span>Demo – click to simulate download</span>
        </div>

        <div class="report-grid">
            <div class="report-card">
                <h3><i class='bx bx-donate-heart'></i> Monetary Donations</h3>
                <p>Summary of all monetary donations by period, donor, and amount.</p>
                <span class="report-stat">₱13.5K</span>
                <button class="report-download-btn" data-report-dl type="button">
                    <i class='bx bx-download'></i> Download CSV
                </button>
            </div>
            <div class="report-card">
                <h3><i class='bx bx-transfer-alt'></i> Hair Donation Report</h3>
                <p>All hair submissions with length, color, and approval status breakdown.</p>
                <span class="report-stat">79 records</span>
                <button class="report-download-btn" data-report-dl type="button">
                    <i class='bx bx-download'></i> Download CSV
                </button>
            </div>
            <div class="report-card">
                <h3><i class='bx bx-package'></i> Wig Production Report</h3>
                <p>Batch-level production progress and wig completion rates by wigmaker.</p>
                <span class="report-stat">4 batches</span>
                <button class="report-download-btn" data-report-dl type="button">
                    <i class='bx bx-download'></i> Download PDF
                </button>
            </div>
            <div class="report-card">
                <h3><i class='bx bx-user-check'></i> Recipient Distribution Report</h3>
                <p>Matched and distributed wigs per recipient, with wig size and color data.</p>
                <span class="report-stat">34 wigs</span>
                <button class="report-download-btn" data-report-dl type="button">
                    <i class='bx bx-download'></i> Download PDF
                </button>
            </div>
            <div class="report-card">
                <h3><i class='bx bx-calendar-event'></i> Events Report</h3>
                <p>Attendance and participation data across all HairLink events in the period.</p>
                <span class="report-stat">6 events</span>
                <button class="report-download-btn" data-report-dl type="button">
                    <i class='bx bx-download'></i> Download CSV
                </button>
            </div>
            <div class="report-card">
                <h3><i class='bx bx-group'></i> User Activity Report</h3>
                <p>New signups, active sessions, and role distribution for all users.</p>
                <span class="report-stat">89 users</span>
                <button class="report-download-btn" data-report-dl type="button">
                    <i class='bx bx-download'></i> Download CSV
                </button>
            </div>
        </div>
    </article>

    {{-- Monthly breakdown table --}}
    <article class="admin-card">
        <div class="admin-card-head">
            <h2><i class='bx bx-bar-chart-alt-2'></i> Monthly Activity Breakdown</h2>
            <span>Jan – Mar 2026</span>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Monetary Donations</th>
                        <th>Hair Submissions</th>
                        <th>Wigs Produced</th>
                        <th>Wigs Distributed</th>
                        <th>New Users</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>January 2026</td>
                        <td>₱4,200</td>
                        <td>28</td>
                        <td>6</td>
                        <td>4</td>
                        <td>12</td>
                    </tr>
                    <tr>
                        <td>February 2026</td>
                        <td>₱5,150</td>
                        <td>34</td>
                        <td>9</td>
                        <td>8</td>
                        <td>18</td>
                    </tr>
                    <tr>
                        <td>March 2026</td>
                        <td>₱4,150</td>
                        <td>17</td>
                        <td>4</td>
                        <td>5</td>
                        <td>9</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>

</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush
