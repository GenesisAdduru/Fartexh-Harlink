@extends('layouts.dashboard')

@section('title', 'HairLink | Admin Inventory')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-module.css') }}">
@endpush

@section('content')
<section class="section-wrap reveal admin-page">

    {{-- ── Page header ─────────────────────────────────────── --}}
    <header style="padding:0.6rem 0 0.2rem">
        <p style="font-size:0.72rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;color:#9b2f69;margin-bottom:0.2rem;">Admin · Inventory</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.5rem,3vw,2.1rem);color:#261d2b;">Check Inventory</h1>
        <p style="color:#665772;font-size:0.88rem;margin-top:0.25rem;">Complete view of all hair stock, wig stock, and delivery batches.</p>
    </header>

    {{-- ── Inventory totals ────────────────────────────────── --}}
    <div class="inv-summary-grid">
        <div class="inv-summary-item">
            <span>Hair Records</span>
            <strong>81</strong>
        </div>
        <div class="inv-summary-item">
            <span>Wig Stock</span>
            <strong>10</strong>
        </div>
        <div class="inv-summary-item">
            <span>Delivery Batches</span>
            <strong>4</strong>
        </div>
        <div class="inv-summary-item">
            <span>Hair Donations</span>
            <strong>79</strong>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         SECTION 1 — Hair Stock
    ════════════════════════════════════════════════════════ --}}
    <article class="admin-card">
        <h3 class="inv-section-title">
            <i class='bx bx-transfer-alt'></i> Hair Stock
            <span style="font-size:0.8rem;font-weight:400;color:#7a687f;font-family:'Manrope',sans-serif;margin-left:auto;">
                Approved &amp; categorized donations
            </span>
        </h3>

        <div class="hair-stock-grid">
            <div class="hair-stock-col">
                <h4>Short</h4>
                <div class="hair-stock-row"><span>Black</span><strong>13</strong></div>
                <div class="hair-stock-row"><span>Brown</span><strong>10</strong></div>
                <div class="hair-stock-row"><span>Light</span><strong>8</strong></div>
                <div class="hair-stock-row" style="border-top:1px solid #ead7e8;margin-top:0.3rem;padding-top:0.3rem;">
                    <span style="font-weight:700;">Total Short</span><strong>31</strong>
                </div>
            </div>
            <div class="hair-stock-col">
                <h4>Medium</h4>
                <div class="hair-stock-row"><span>Black</span><strong>7</strong></div>
                <div class="hair-stock-row"><span>Brown</span><strong>11</strong></div>
                <div class="hair-stock-row"><span>Light</span><strong>6</strong></div>
                <div class="hair-stock-row" style="border-top:1px solid #ead7e8;margin-top:0.3rem;padding-top:0.3rem;">
                    <span style="font-weight:700;">Total Medium</span><strong>24</strong>
                </div>
            </div>
            <div class="hair-stock-col">
                <h4>Long</h4>
                <div class="hair-stock-row"><span>Black</span><strong>9</strong></div>
                <div class="hair-stock-row"><span>Brown</span><strong>12</strong></div>
                <div class="hair-stock-row"><span>Light</span><strong>5</strong></div>
                <div class="hair-stock-row" style="border-top:1px solid #ead7e8;margin-top:0.3rem;padding-top:0.3rem;">
                    <span style="font-weight:700;">Total Long</span><strong>26</strong>
                </div>
            </div>
        </div>
        <p class="admin-empty-note" style="padding-top:0.65rem;">Combined total: <strong>81</strong> hair records across all sizes and colors.</p>
    </article>

    {{-- ══════════════════════════════════════════════════════
         SECTION 2 — Wig Stock
    ════════════════════════════════════════════════════════ --}}
    <article class="admin-card" data-admin-search-block>
        <div class="admin-bar">
            <h3 class="inv-section-title" style="margin-bottom:0;border-bottom:none;padding-bottom:0;">
                <i class='bx bx-package'></i> Wig Stock
            </h3>
            <div class="admin-tools">
                <input type="text" placeholder="Search stock…" data-admin-search-input aria-label="Search wig stock">
                <button class="soft-btn" data-admin-search-btn type="button">Search</button>
                <button class="ghost-btn" type="button" data-admin-print>Print</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Stock ID</th>
                        <th>Batch</th>
                        <th>Wig Size</th>
                        <th>Color</th>
                        <th>Date Delivered</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-admin-search-row><td>A101</td><td>001</td><td>Long</td><td>Brown</td><td>04/13/24</td><td><span class="admin-chip arrived">Arrived</span></td></tr>
                    <tr data-admin-search-row><td>A102</td><td>001</td><td>Short</td><td>Black</td><td>04/13/24</td><td><span class="admin-chip arrived">Arrived</span></td></tr>
                    <tr data-admin-search-row><td>A103</td><td>001</td><td>Long</td><td>Black</td><td>04/13/24</td><td><span class="admin-chip arrived">Arrived</span></td></tr>
                    <tr data-admin-search-row><td>A104</td><td>001</td><td>Long</td><td>Light</td><td>04/18/24</td><td><span class="admin-chip arrived">Arrived</span></td></tr>
                    <tr data-admin-search-row><td>A105</td><td>002</td><td>Short</td><td>Brown</td><td>05/18/24</td><td><span class="admin-chip transit">In Transit</span></td></tr>
                    <tr data-admin-search-row><td>A106</td><td>002</td><td>Long</td><td>Brown</td><td>05/18/25</td><td><span class="admin-chip transit">In Transit</span></td></tr>
                    <tr data-admin-search-row><td>A107</td><td>003</td><td>Medium</td><td>Black</td><td>06/22/25</td><td><span class="admin-chip available">Available</span></td></tr>
                    <tr data-admin-search-row><td>A108</td><td>003</td><td>Short</td><td>Light</td><td>06/22/25</td><td><span class="admin-chip available">Available</span></td></tr>
                    <tr data-admin-search-row><td>A109</td><td>003</td><td>Medium</td><td>Brown</td><td>07/10/25</td><td><span class="admin-chip allocated">Allocated</span></td></tr>
                    <tr data-admin-search-row><td>A110</td><td>003</td><td>Long</td><td>Black</td><td>07/10/25</td><td><span class="admin-chip available">Available</span></td></tr>
                </tbody>
            </table>
        </div>

        <div class="admin-pager">
            <button class="active" type="button">1</button>
            <button type="button">2</button>
            <button type="button">3</button>
        </div>
    </article>

    {{-- ══════════════════════════════════════════════════════
         SECTION 3 — Delivery Batches
    ════════════════════════════════════════════════════════ --}}
    <article class="admin-card">
        <div class="admin-bar">
            <h3 class="inv-section-title" style="margin-bottom:0;border-bottom:none;padding-bottom:0;">
                <i class='bx bx-truck'></i> Delivery Batches
            </h3>
            <span style="font-size:0.8rem;color:#7a687f;">4 active batches</span>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Batch No.</th>
                        <th>Wigmaker</th>
                        <th>Wig Count</th>
                        <th>Dispatch Date</th>
                        <th>Expected Arrival</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Aling Rosa's Craft</td>
                        <td>4</td>
                        <td>Apr 10, 2024</td>
                        <td>Apr 13, 2024</td>
                        <td><span class="admin-chip arrived">Arrived</span></td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Aling Rosa's Craft</td>
                        <td>2</td>
                        <td>May 15, 2024</td>
                        <td>May 18, 2024</td>
                        <td><span class="admin-chip transit">In Transit</span></td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Reyes Wig Studio</td>
                        <td>4</td>
                        <td>Jun 20, 2025</td>
                        <td>Jun 22, 2025</td>
                        <td><span class="admin-chip arrived">Arrived</span></td>
                    </tr>
                    <tr>
                        <td>004</td>
                        <td>Reyes Wig Studio</td>
                        <td>3</td>
                        <td>Mar 25, 2026</td>
                        <td>Mar 29, 2026</td>
                        <td><span class="admin-chip transit">In Transit</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>

    {{-- ══════════════════════════════════════════════════════
         SECTION 4 — Hair Donation Records
    ════════════════════════════════════════════════════════ --}}
    <article class="admin-card" data-admin-search-block>
        <div class="admin-bar">
            <h3 class="inv-section-title" style="margin-bottom:0;border-bottom:none;padding-bottom:0;">
                <i class='bx bx-user-voice'></i> Hair Donation Records
            </h3>
            <div class="admin-tools">
                <input type="text" placeholder="Search donor or reference…" data-admin-search-input aria-label="Search donations">
                <button class="soft-btn" data-admin-search-btn type="button">Search</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Donor Name</th>
                        <th>Length</th>
                        <th>Color</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-admin-search-row><td>HD-0001</td><td>Maria Santos</td><td>Long</td><td>Black</td><td>Jan 05, 2026</td><td><span class="admin-chip approved">Approved</span></td></tr>
                    <tr data-admin-search-row><td>HD-0002</td><td>Jose Dela Cruz</td><td>Medium</td><td>Brown</td><td>Jan 08, 2026</td><td><span class="admin-chip approved">Approved</span></td></tr>
                    <tr data-admin-search-row><td>HD-0003</td><td>Linda Cruz</td><td>Short</td><td>Light</td><td>Jan 12, 2026</td><td><span class="admin-chip pending">Pending</span></td></tr>
                    <tr data-admin-search-row><td>HD-0004</td><td>Ana Reyes</td><td>Long</td><td>Brown</td><td>Jan 15, 2026</td><td><span class="admin-chip approved">Approved</span></td></tr>
                    <tr data-admin-search-row><td>HD-0005</td><td>Roberto Lim</td><td>Medium</td><td>Black</td><td>Jan 18, 2026</td><td><span class="admin-chip rejected">Rejected</span></td></tr>
                    <tr data-admin-search-row><td>HD-0006</td><td>Carmen Torres</td><td>Long</td><td>Black</td><td>Jan 22, 2026</td><td><span class="admin-chip approved">Approved</span></td></tr>
                    <tr data-admin-search-row><td>HD-0007</td><td>Miguel Fernandez</td><td>Short</td><td>Brown</td><td>Feb 02, 2026</td><td><span class="admin-chip approved">Approved</span></td></tr>
                    <tr data-admin-search-row><td>HD-0008</td><td>Sofia Tan</td><td>Medium</td><td>Light</td><td>Feb 07, 2026</td><td><span class="admin-chip pending">Pending</span></td></tr>
                </tbody>
            </table>
        </div>

        <div class="admin-pager">
            <button class="active" type="button">1</button>
            <button type="button">2</button>
            <button type="button">3</button>
            <button type="button">4</button>
        </div>
    </article>

</section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin-module.js') }}" defer></script>
@endpush
