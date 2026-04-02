<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
    <meta name="app-base-url" content="{{ url('/') }}">
=======
    <meta name="csrf-token" content="{{ csrf_token() }}">
>>>>>>> d2bbf6d75baffef7ffe60137c02114cb465cea0e
    <title>@yield('title', config('app.name', 'HairLink'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/css/auth-base.css') }}">
    @stack('styles')
</head>
<body>
    <x-auth.navbar />
    @yield('content')
    <script src="{{ asset('assets/js/auth-base.js') }}" defer></script>
    @stack('scripts')
</body>
</html>