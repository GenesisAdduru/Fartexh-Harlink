@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Recipient Matching List')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="staff-block" data-search-block>
        <div class="staff-bar">
            <h2>Recipient Matching List</h2>
            <div class="staff-tools">
                <input type="text" placeholder="Search recipient" data-search-input>
                <button type="button" class="soft-btn">Search</button>
                <button type="button" class="ghost-btn">Filter</button>
                <button type="button" class="ghost-btn" data-print-trigger>Print</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Matched Wig</th>
                        <th>Status</th>
                        <th>Pick-up Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-search-row><td>Marie Santos</td><td>A101</td><td>Arrived</td><td>04/13/24</td></tr>
                    <tr data-search-row><td>Patrixia Lopez</td><td>A105</td><td>Arrived</td><td>04/13/24</td></tr>
                    <tr data-search-row><td>Grace Dela Fuente</td><td>A106</td><td>Arrived</td><td>04/13/24</td></tr>
                    <tr data-search-row><td>Xyliana Nogrado</td><td>A102</td><td>Arrived</td><td>04/18/24</td></tr>
                    <tr data-search-row><td>Chanell Alonzo</td><td>A109</td><td>In Transit</td><td>05/18/24</td></tr>
                    <tr data-search-row><td>Princess Tan</td><td>A108</td><td>In Transit</td><td>05/18/25</td></tr>
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
