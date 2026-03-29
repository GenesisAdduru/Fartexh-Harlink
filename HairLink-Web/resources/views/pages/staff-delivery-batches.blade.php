@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Delivery Per Batch')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="staff-block" data-search-block>
        <div class="staff-bar">
            <h2>Delivery Per Batch</h2>
            <div class="staff-tools">
                <input type="text" placeholder="Search batch" data-search-input>
                <button type="button" class="soft-btn">Search</button>
                <button type="button" class="ghost-btn" data-print-trigger>Print</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Batch #</th>
                        <th>Date and Time</th>
                        <th>Number of hairs per batch</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-search-row><td>Batch 1</td><td>03/24/24 10:23:50</td><td>42</td><td>Completed</td></tr>
                    <tr data-search-row><td>Batch 2</td><td>09/15/24 11:42:15</td><td>39</td><td>Completed</td></tr>
                    <tr data-search-row><td>Batch 3</td><td>03/25/24 11:45:09</td><td>56</td><td>Completed</td></tr>
                    <tr data-search-row><td>Batch 4</td><td>04/03/24 12:03:46</td><td>41</td><td>Completed</td></tr>
                    <tr data-search-row><td>Batch 5</td><td>11/26/24 12:10:36</td><td>56</td><td>In Process</td></tr>
                    <tr data-search-row><td>Batch 6</td><td>06/26/24 10:57:43</td><td>39</td><td>Pending</td></tr>
                </tbody>
            </table>
        </div>

        <div class="pager">
            <button class="active" type="button">1</button>
            <button type="button">2</button>
            <button type="button">3</button>
            <button type="button">4</button>
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
