@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Wig Stock')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="staff-block" data-search-block>
        <div class="staff-bar">
            <h2>Wig Stock</h2>
            <div class="staff-tools">
                <input type="text" placeholder="Search stock" data-search-input>
                <button type="button" class="soft-btn">Search</button>
                <button type="button" class="ghost-btn">Filter</button>
                <button type="button" class="ghost-btn" data-print-trigger>Print</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Stock ID</th>
                        <th>Batch Number</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Date Delivered</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-search-row><td>A101</td><td>001</td><td>Long</td><td>Brown</td><td>04/13/24</td><td>Arrived</td></tr>
                    <tr data-search-row><td>A102</td><td>001</td><td>Short</td><td>Black</td><td>04/13/24</td><td>Arrived</td></tr>
                    <tr data-search-row><td>A103</td><td>001</td><td>Long</td><td>Black</td><td>04/13/24</td><td>Arrived</td></tr>
                    <tr data-search-row><td>A104</td><td>001</td><td>Long</td><td>Light</td><td>04/18/24</td><td>Arrived</td></tr>
                    <tr data-search-row><td>A105</td><td>002</td><td>Short</td><td>Brown</td><td>05/18/24</td><td>In Transit</td></tr>
                    <tr data-search-row><td>A106</td><td>002</td><td>Long</td><td>Brown</td><td>05/18/25</td><td>In Transit</td></tr>
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
