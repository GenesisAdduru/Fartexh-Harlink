@extends('layouts.dashboard')

@section('title', 'HairLink | Staff Rule-based Matching')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/staff-module.css') }}">
@endpush

@section('content')
@php
    $targetRef  = request()->query('ref');
    $singleMode = !empty($targetRef);

    // When a specific ref is provided, scope to just that recipient.
    // Otherwise fall back to the full list.
    if ($singleMode) {
        $selectedRec = $recipients->firstWhere('reference', $targetRef);
    } else {
        $selectedRec = $recipients->first();
    }
@endphp

<section class="section-wrap reveal staff-page">

    {{-- ── Back nav (only in single-focus mode) ── --}}
    @if($singleMode)
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('staff.recipient-matching-list') }}"
           style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.82rem; font-weight: 700; color: #ad246d; text-decoration: none; transition: opacity 0.2s;"
           onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
            <i class='bx bx-arrow-back'></i> Back to Matching List
        </a>
    </div>
    @endif

    <article class="match-layout">

        {{-- ── LEFT PANEL ── --}}
        <section class="match-left">

            @if($singleMode)
                {{-- Single-focus mode: show only the targeted recipient, no list --}}
                <h2>Recipient</h2>

                @if($selectedRec)
                    <div class="recipient-facts"
                         style="background: linear-gradient(135deg,#fdf1f8 0%,#fff 100%);
                                border: 2px solid #e8c6de; border-radius: 14px; padding: 1.1rem 1.25rem;
                                margin-bottom: 0.5rem;">
                        <strong data-recipient-name style="font-size: 1.05rem; color: #3b2e43;">
                            {{ $selectedRec->user->first_name ?? 'Unknown' }}
                            {{ $selectedRec->user->last_name ?? 'User' }}
                        </strong>
                        <span style="font-size: 0.78rem; color: #8c7895; margin-top: 0.2rem; display: block;">
                            Request # {{ $selectedRec->reference }}
                        </span>
                        <span style="margin-top: 0.6rem; display: block;">
                            Preferred Wig Size:
                            <strong data-recipient-length>{{ ucfirst($selectedRec->wig_length ?? 'N/A') }}</strong>
                        </span>
                        <span>Preferred Color:
                            <strong data-recipient-color>{{ ucfirst($selectedRec->wig_color ?? 'N/A') }}</strong>
                        </span>
                    </div>

                    {{-- Hidden button that JS uses as the "active" recipient source --}}
                    <button type="button"
                            class="recipient-btn active"
                            data-recipient-btn
                            data-reference="{{ $selectedRec->reference }}"
                            data-name="{{ ($selectedRec->user->first_name ?? 'Unknown') . ' ' . ($selectedRec->user->last_name ?? 'User') }}"
                            data-length="{{ $selectedRec->wig_length }}"
                            data-color="{{ $selectedRec->wig_color }}"
                            style="display: none;">
                    </button>
                @else
                    <p style="color:#e74c3c; font-size: 0.88rem;">
                        ⚠ Recipient not found or no longer pending matching.
                        <a href="{{ route('staff.recipient-matching-list') }}" style="color:#ad246d;">Return to list →</a>
                    </p>
                @endif

            @else
                {{-- Full-list mode: show all available recipients --}}
                <h2>Select Recipient</h2>

                @if($selectedRec)
                <div class="recipient-facts">
                    <strong data-recipient-name>
                        {{ $selectedRec->user->first_name ?? 'Select' }}
                        {{ $selectedRec->user->last_name ?? 'Recipient' }}
                    </strong>
                    <span>Preferred Wig Size:
                        <strong data-recipient-length>{{ ucfirst($selectedRec->wig_length ?? 'N/A') }}</strong>
                    </span>
                    <span>Preferred Color:
                        <strong data-recipient-color>{{ ucfirst($selectedRec->wig_color ?? 'N/A') }}</strong>
                    </span>
                </div>
                @endif

                <div class="recipient-list">
                    @forelse($recipients as $rec)
                        <button type="button"
                                class="recipient-btn {{ $selectedRec && $selectedRec->reference === $rec->reference ? 'active' : '' }}"
                                data-recipient-btn
                                data-reference="{{ $rec->reference }}"
                                data-name="{{ ($rec->user->first_name ?? 'Unknown') . ' ' . ($rec->user->last_name ?? 'User') }}"
                                data-length="{{ $rec->wig_length }}"
                                data-color="{{ $rec->wig_color }}">
                            {{ $rec->user->first_name ?? 'Unknown' }} {{ $rec->user->last_name ?? 'User' }}
                            <b>{{ $rec->status }}</b>
                        </button>
                    @empty
                        <p>No recipients pending matching.</p>
                    @endforelse
                </div>
            @endif

        </section>

        {{-- ── RIGHT PANEL: always shown ── --}}
        <section class="match-right">
            <h2>Available Wigs</h2>
            <p class="match-rule-note" style="margin-top: 1rem;">
                Ranking rule: highest compatibility score first.
                Tie-breaker: oldest in-stock wig first (FIFO).
            </p>

            <div class="wig-options">
                @forelse($wigs as $wig)
                    @php
                        $sizeLabel = ucfirst($wig->target_length);
                        if (str_contains(strtolower($sizeLabel), '10 to 14'))     $sizeLabel = 'Short';
                        if (str_contains(strtolower($sizeLabel), '15 to 20'))     $sizeLabel = 'Medium';
                        if (str_contains(strtolower($sizeLabel), 'more than 20')) $sizeLabel = 'Long';
                    @endphp
                    <article class="wig-option"
                             data-wig-card
                             data-length="{{ $wig->target_length }}"
                             data-color="{{ $wig->target_color }}"
                             data-available="true"
                             data-stock-date="{{ $wig->updated_at->format('Y-m-d') }}"
                             hidden>

                        <div class="match-badge" data-best-match-badge hidden
                             style="position: absolute; top: -10px; right: -10px;
                                    background: linear-gradient(135deg, #ad246d 0%, #cf2f84 100%);
                                    color: #fff; padding: 0.3rem 0.8rem; border-radius: 20px;
                                    font-size: 0.7rem; font-weight: 800;
                                    box-shadow: 0 4px 10px rgba(173,36,109,0.3);
                                    z-index: 10; border: 2px solid #fff;">
                            <i class='bx bxs-star' style="margin-right: 2px;"></i> Best Match
                        </div>

                        <h4>Stock #{{ $wig->task_code }}</h4>
                        <p>Wig Size: <strong>{{ $sizeLabel }}</strong></p>
                        <p>Color: <strong>{{ ucfirst(str_replace('-', ' ', $wig->target_color)) }}</strong></p>
                        <p>Availability: In Stock</p>
                        <p class="compat-score">Compatibility Score: <span data-score>0%</span></p>
                        <p class="score-breakdown" data-score-breakdown>Calculating...</p>

                        <button class="soft-btn" type="button" data-match-btn data-wig-id="{{ $wig->id }}">
                            Choose this wig
                        </button>
                    </article>
                @empty
                    <p>No wigs currently in stock.</p>
                @endforelse

                <p class="empty-note" data-match-empty hidden>
                    No compatible wig found for the current recipient. Please wait for new stock.
                </p>
            </div>
        </section>

    </article>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/staff-module.js') }}" defer></script>
@endpush
