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
                    @forelse($wigs as $wig)
                        <tr data-search-row>
                            <td><strong>{{ $wig->task_code }}</strong></td>
                            <td>{{ $wig->donation ? $wig->donation->reference : 'N/A' }}</td>
                            <td>{{ $wig->target_length }}</td>
                            <td>{{ $wig->target_color }}</td>
                            <td>{{ $wig->updated_at->format('m/d/y') }}</td>
                            <td><span class="status-chip" style="background:#d4edda;color:#155724;border:none;">Arrived</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">No wigs currently in stock.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pager">
            {{ $wigs->links() }}
        </div>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
