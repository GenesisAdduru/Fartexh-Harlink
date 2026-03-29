<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HairLink | Strand Up For Cancer</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
</head>
<body>
    <x-landing.header />
    <x-landing.hero />
    <x-landing.services />
    <x-landing.about />
    <x-landing.contact />
    <x-landing.footer />

    <script src="{{ asset('assets/js/landing.js') }}" defer></script>
</body>
</html>
