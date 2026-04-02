@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Rule-based Matching')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal staff-page">
    <article class="match-layout">
        <section class="match-left">
            <h2>Select Recipient</h2>

            <div class="recipient-facts">
                <strong data-recipient-name>Maria Santos</strong>
                <span>Medical Need: <span data-recipient-need>Chemotherapy</span></span>
                <span>Preferred Wig Size: <span data-recipient-length>Long</span></span>
                <span>Preferred Color: <span data-recipient-color>Black</span></span>
            </div>

            <div class="recipient-list">
                <button type="button" class="recipient-btn active" data-recipient-btn data-name="Maria Santos" data-need="Chemotherapy" data-length="Long" data-color="Black">Maria Santos <b>Open</b></button>
                <button type="button" class="recipient-btn" data-recipient-btn data-name="Patrixia Lopez" data-need="Alopecia" data-length="Short" data-color="Brown">Patrixia Lopez <b>Open</b></button>
                <button type="button" class="recipient-btn" data-recipient-btn data-name="Grace Dela Fuente" data-need="Chemo Recovery" data-length="Long" data-color="Brown">Grace Dela Fuente <b>Open</b></button>
                <button type="button" class="recipient-btn" data-recipient-btn data-name="Xyliana Nogrado" data-need="Medical Hair Loss" data-length="Medium" data-color="Black">Xyliana Nogrado <b>Open</b></button>
                <button type="button" class="recipient-btn" data-recipient-btn data-name="Chanell Alonzo" data-need="Chemotherapy" data-length="Long" data-color="Light">Chanell Alonzo <b>Open</b></button>
            </div>
        </section>

        <section class="match-right">
            <h2>Available Wigs</h2>
            <div class="match-tools">
                <label for="matchMode">Display:</label>
                <select id="matchMode" data-match-mode>
                    <option value="high" selected>High Matches (>= 85%)</option>
                    <option value="top3">Top 3 Highest Matches</option>
                    <option value="all">All Available Wigs</option>
                </select>
            </div>
            <p class="match-rule-note">Ranking rule: highest compatibility score first. Tie-breaker: oldest in-stock wig first (FIFO).</p>
            <div class="wig-options">
                <article class="wig-option" data-wig-card data-length="Long" data-color="Black" data-available="true" data-stock-date="2026-01-12">
                    <h4>Donor Wig #A102</h4>
                    <p>Wig Size: Long</p>
                    <p>Color: Black</p>
                    <p>Availability: In Stock</p>
                    <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                    <p class="score-breakdown" data-score-breakdown>Size 0 + Color 0 + Availability 0 = 0</p>
                    <button class="soft-btn" type="button">Choose this wig</button>
                </article>

                <article class="wig-option" data-wig-card data-length="Long" data-color="Brown" data-available="true" data-stock-date="2026-01-18">
                    <h4>Donor Wig #B087</h4>
                    <p>Wig Size: Long</p>
                    <p>Color: Dark Brown</p>
                    <p>Availability: In Stock</p>
                    <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                    <p class="score-breakdown" data-score-breakdown>Size 0 + Color 0 + Availability 0 = 0</p>
                    <button class="soft-btn" type="button">Choose this wig</button>
                </article>

                <article class="wig-option" data-wig-card data-length="Medium" data-color="Brown" data-available="true" data-stock-date="2026-02-02">
                    <h4>Donor Wig #C014</h4>
                    <p>Wig Size: Medium</p>
                    <p>Color: Brown</p>
                    <p>Availability: In Stock</p>
                    <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                    <p class="score-breakdown" data-score-breakdown>Size 0 + Color 0 + Availability 0 = 0</p>
                    <button class="soft-btn" type="button">Choose this wig</button>
                </article>

                <article class="wig-option" data-wig-card data-length="Short" data-color="Brown" data-available="true" data-stock-date="2025-12-09">
                    <h4>Donor Wig #D221</h4>
                    <p>Wig Size: Short</p>
                    <p>Color: Brown</p>
                    <p>Availability: In Stock</p>
                    <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                    <p class="score-breakdown" data-score-breakdown>Size 0 + Color 0 + Availability 0 = 0</p>
                    <button class="soft-btn" type="button">Choose this wig</button>
                </article>

                <article class="wig-option" data-wig-card data-length="Medium" data-color="Black" data-available="true" data-stock-date="2026-01-05">
                    <h4>Donor Wig #E199</h4>
                    <p>Wig Size: Medium</p>
                    <p>Color: Black</p>
                    <p>Availability: In Stock</p>
                    <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                    <p class="score-breakdown" data-score-breakdown>Size 0 + Color 0 + Availability 0 = 0</p>
                    <button class="soft-btn" type="button">Choose this wig</button>
                </article>

                <article class="wig-option" data-wig-card data-length="Long" data-color="Light" data-available="false" data-stock-date="2026-02-10">
                    <h4>Donor Wig #F041</h4>
                    <p>Wig Size: Long</p>
                    <p>Color: Light</p>
                    <p>Availability: Reserved</p>
                    <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                    <p class="score-breakdown" data-score-breakdown>Size 0 + Color 0 + Availability 0 = 0</p>
                    <button class="soft-btn" type="button" disabled>Not Available</button>
                </article>
            </div>
            <p class="empty-note" data-match-empty hidden>No high-match wig found for the current recipient. Switch to "All Available Wigs" to review more options.</p>
        </section>
    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
