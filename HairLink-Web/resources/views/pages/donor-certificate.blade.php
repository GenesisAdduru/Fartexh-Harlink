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
                @if($donation && $donation->status === 'Completed')
                <button id="printCertificateBtn" class="soft-btn" type="button">Print / Save as PDF</button>
                @endif
            </div>
        </header>

        <article class="module-card certificate-shell">
            @if($donation)
            <div class="certificate-paper" id="certificatePaper">
                <p class="certificate-title">Certificate of Hair Donation</p>
                <p class="certificate-copy">This certifies that</p>
                <p class="certificate-name" id="certName">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                <p class="certificate-copy">has generously donated hair to support patients experiencing medical hair loss.</p>

                <div class="certificate-meta">
                    <p>Donation Reference: <strong id="certReference">{{ $donation->reference }}</strong></p>
                    <p>Certificate Number: <strong id="certNumber">{{ $donation->certificate_no ?? 'Pending' }}</strong></p>
                    <p>Date Issued: <strong id="certIssued">{{ $donation->status === 'Completed' ? $donation->updated_at->format('M d, Y') : 'Pending completion' }}</strong></p>
                    <p>Donation Status: <strong id="certStatus">{{ $donation->status }}</strong></p>
                </div>
            </div>

            <div class="note-box" id="certificateStatusNote">
                @if($donation->status === 'Completed')
                Certificate is ready. Click "Print / Save as PDF" to download.
                @else
                Certificate is currently unavailable until donation status is Completed. Current status: {{ $donation->status }}.
                @endif
            </div>
            @else
            <div class="note-box">
                No verified or completed donation record found. Submit a donation and wait for verification to view your certificate.
            </div>
            @endif
        </article>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/donor-module.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const printBtn = document.getElementById('printCertificateBtn');
            if (printBtn) {
                printBtn.addEventListener('click', () => {
                    window.print();
                });
            }
        });
    </script>
@endpush
