@extends('layouts.auth')

@section('title', 'Verify Your Email')

@push('styles')
    <style>
        .verification-overlay {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            padding: 2rem;
            background: #fff0f5;
        }

        .verification-card {
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(184, 56, 112, 0.1);
            max-width: 500px;
            text-align: center;
            border: 1px solid #fce4ec;
        }

        .envelope-icon {
            font-size: 64px;
            color: #d81b60;
            margin-bottom: 20px;
        }

        .verification-card h1 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }

        .verification-card p {
            color: #555;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .resend-btn {
            background-color: #d81b60;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .resend-btn:hover {
            background-color: #b0124a;
        }

        .success-msg {
            color: #27ae60;
            background: #e8f8f5;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
<div class="verification-overlay">
    <div class="verification-card">
        <div class="envelope-icon">
            <i class='bx bx-envelope-open'></i>
        </div>
        <h1>Check your inbox</h1>
        
        @if (session('message'))
            <div class="success-msg">
                {{ session('message') }}
            </div>
        @endif

        <p>Before you can access your dashboard, please verify your email address by clicking on the link we just emailed to you.</p>
        <p>If you didn't receive the email, we will gladly send you another.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="resend-btn">Resend Verification Email</button>
        </form>
    </div>
</div>
@endsection
