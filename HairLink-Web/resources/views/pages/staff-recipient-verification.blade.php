@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Recipient Request Verification')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="staff-block" data-search-block>
        <div class="staff-bar">
            <h2>Recipient Request Verification Queue</h2>
            <div class="staff-tools">
                <input type="text" placeholder="Search recipient or reference" data-search-input>
                <select>
                    <option>All Status</option>
                    <option>Submitted</option>
                    <option>Under Review</option>
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
                        <th>Recipient</th>
                        <th>Wig Preference</th>
                        <th>Medical Need</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-search-row>
                        <td>REC-2026-0448</td>
                        <td>Maria Santos</td>
                        <td>Long / Black</td>
                        <td>Chemotherapy</td>
                        <td><span class="status-chip">Under Review</span></td>
                        <td><a class="ghost-btn" href="{{ route('staff.verification.detail', ['type' => 'recipient', 'reference' => 'REC-2026-0448']) }}">Review</a></td>
                    </tr>
                    <tr data-search-row>
                        <td>REC-2026-0451</td>
                        <td>Patrixia Lopez</td>
                        <td>Short / Brown</td>
                        <td>Alopecia</td>
                        <td><span class="status-chip">Under Review</span></td>
                        <td><a class="ghost-btn" href="{{ route('staff.verification.detail', ['type' => 'recipient', 'reference' => 'REC-2026-0451']) }}">Review</a></td>
                    </tr>
                    <tr data-search-row>
                        <td>REC-2026-0453</td>
                        <td>Grace Dela Fuente</td>
                        <td>Medium / Brown</td>
                        <td>Chemo Recovery</td>
                        <td><span class="status-chip">Submitted</span></td>
                        <td><a class="ghost-btn" href="{{ route('staff.verification.detail', ['type' => 'recipient', 'reference' => 'REC-2026-0453']) }}">Review</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="empty-note">Approval decision updates recipient tracking and matching eligibility.</div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
