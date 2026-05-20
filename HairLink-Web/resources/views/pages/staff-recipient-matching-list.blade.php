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
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date Updated</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr data-search-row>
                        <td>{{ $request->user->first_name ?? '' }} {{ $request->user->last_name ?? '' }}</td>
                        <td>{{ $request->reference }}</td>
                        <td>{{ $request->status }}</td>
                        <td>{{ $request->updated_at->format('m/d/y') }}</td>
                        <td style="text-align: right;">
                            @if($request->status === 'Validated')
                                <a href="{{ route('staff.rule-matching') }}?ref={{ $request->reference }}" class="soft-btn" style="padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                                    <i class='bx bx-user-plus'></i> Match
                                </a>
                            @else
                                <span style="font-size: 0.7rem; color: #8c7895; font-style: italic;">In Progress</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#7a687f; padding: 2rem;">No recipients pending matching.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
