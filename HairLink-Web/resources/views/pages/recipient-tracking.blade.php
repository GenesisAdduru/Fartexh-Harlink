@extends('layouts.dashboard')

@section('title', 'Request Tracking')

@section('content')
<div class="section-wrap">
    <div class="module-head">
        <h1>Your Requests</h1>
        <p>Track the status of your hair requests and updates.</p>
    </div>

    <!-- Search Filter -->
    <div class="tracking-search">
        <input type="text" id="search-requests" placeholder="Search by reference, status, or name..." class="search-input">
    </div>

    <!-- Requests Table -->
    <div class="tracking-table-wrap">
        <table class="tracking-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="requests-list">
                <tr class="empty-state">
                    <td colspan="5">No requests found. <a href="{{ route('recipient.request') }}">Submit your first request</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('assets/js/recipient-tracking.js') }}"></script>
@endsection
