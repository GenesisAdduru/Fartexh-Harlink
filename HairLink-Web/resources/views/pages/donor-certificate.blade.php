@extends('layouts.dashboard')

@section('title', 'HairLink | Donor Certificate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/donor-module.css') }}">
@endpush

@section('content')
    <section class="section-wrap donor-module-page reveal" id="certificateRoot">
        <header class="module-head">
            <h1>Donor Certificate</h1>
            <p>Automatically generated once your donation reaches Completed status.</p>
            <div class="action-row">
                <a class="ghost-btn" href="{{ route('donor.tracking') }}">Back to Tracking</a>
                <button id="printCertificateBtn" class="soft-btn" type="button">Print / Save as PDF</button>
            </div>
        </header>

        <article class="module-card certificate-shell">
            <div class="certificate-paper" id="certificatePaper">
                <p class="certificate-title">Certificate of Hair Donation</p>
                <p class="certificate-copy">This certifies that</p>
                <p class="certificate-name" id="certName">-</p>
                <p class="certificate-copy">has generously donated hair to support patients experiencing medical hair loss.</p>

                <div class="certificate-meta">
                    <p>Donation Reference: <strong id="certReference">-</strong></p>
                    <p>Certificate Number: <strong id="certNumber">-</strong></p>
                    <p>Date Issued: <strong id="certIssued">-</strong></p>
                    <p>Donation Status: <strong id="certStatus">-</strong></p>
                </div>
            </div>

            <div class="note-box" id="certificateStatusNote">
                Certificate is currently unavailable until donation status is Completed.
            </div>
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-module.js') }}" defer></script>
    <script src="{{ asset('assets/js/donor-certificate.js') }}" defer></script>
@endpush
