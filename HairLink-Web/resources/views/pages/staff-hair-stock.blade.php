@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Hair Stock')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="stock-panel">
        <h2>Hair Stock</h2>

        <div class="stock-columns">
            <section class="stock-col">
                <h3>Short</h3>
                <div class="stock-row"><span>Black</span><strong>13</strong></div>
                <div class="stock-row"><span>Brown</span><strong>10</strong></div>
                <div class="stock-row"><span>Light</span><strong>8</strong></div>
            </section>
            <section class="stock-col">
                <h3>Medium</h3>
                <div class="stock-row"><span>Black</span><strong>7</strong></div>
                <div class="stock-row"><span>Brown</span><strong>11</strong></div>
                <div class="stock-row"><span>Light</span><strong>6</strong></div>
            </section>
            <section class="stock-col">
                <h3>Long</h3>
                <div class="stock-row"><span>Black</span><strong>9</strong></div>
                <div class="stock-row"><span>Brown</span><strong>12</strong></div>
                <div class="stock-row"><span>Light</span><strong>5</strong></div>
            </section>
        </div>

        <p class="empty-note">Stock values are digital inventory summaries from approved and categorized hair donations.</p>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
