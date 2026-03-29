@extends('layouts.dashboard')

@section('title', 'HairLink | Donation Tracking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/donor-module.css') }}">
@endpush

@section('content')
    <section class="section-wrap donor-module-page reveal">
        <header class="module-head">
            <h1>My Donation Tracking</h1>
            <p>Monitor status changes from submission to completion and certificate release.</p>
            <div class="tracking-tools">
                <input id="trackingFilter" type="text" placeholder="Search by reference, status, hair details...">
                <a class="soft-btn" href="{{ route('donor.donate') }}">Submit Another Donation</a>
            </div>
        </header>

        <article class="module-card">
            <div class="table-wrap">
                <table class="tracking-table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th>Hair Length</th>
                            <th>Certificate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="trackingTableBody"></tbody>
                </table>
            </div>

            <div class="empty-state" id="trackingEmpty" hidden>
                No donation records yet. Submit your first hair donation to begin tracking.
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-module.js') }}" defer></script>
    <script src="{{ asset('assets/js/donor-tracking.js') }}" defer></script>
@endpush
