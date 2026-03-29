@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Donor Hair Verification')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="staff-block" data-search-block>
        <div class="staff-bar">
            <h2>Donor Hair Verification Queue</h2>
            <div class="staff-tools">
                <input type="text" placeholder="Search donor or reference" data-search-input>
                <select>
                    <option>All Status</option>
                    <option>Submitted</option>
                    <option>Approved</option>
                    <option>Rejected</option>
                </select>
            </div>
        </div>

        <div class="table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Donor</th>
                        <th>Hair Details</th>
                        <th>Submitted</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-search-row>
                        <td>DON-2026-1102</td>
                        <td>Fiona Can</td>
                        <td>Long / Black / Untreated</td>
                        <td>03/25/26</td>
                        <td><span class="status-chip">Submitted</span></td>
                        <td><a class="ghost-btn" href="{{ route('staff.verification.detail', ['type' => 'donor', 'reference' => 'DON-2026-1102']) }}">Review</a></td>
                    </tr>
                    <tr data-search-row>
                        <td>DON-2026-1114</td>
                        <td>Lara Mendiola</td>
                        <td>Medium / Brown / Treated</td>
                        <td>03/26/26</td>
                        <td><span class="status-chip">Submitted</span></td>
                        <td><a class="ghost-btn" href="{{ route('staff.verification.detail', ['type' => 'donor', 'reference' => 'DON-2026-1114']) }}">Review</a></td>
                    </tr>
                    <tr data-search-row>
                        <td>DON-2026-1119</td>
                        <td>May Delos Reyes</td>
                        <td>Short / Light / Untreated</td>
                        <td>03/27/26</td>
                        <td><span class="status-chip">Submitted</span></td>
                        <td><a class="ghost-btn" href="{{ route('staff.verification.detail', ['type' => 'donor', 'reference' => 'DON-2026-1119']) }}">Review</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="empty-note">Manual staff validation is required before inventory intake.</div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
