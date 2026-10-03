@php
    $m        = $seo ?? $data['metadata'] ?? [];
    $meta     = fn ($key) => $m[$key] ?? config('metadata.' . $key);
    $ogImage  = $m['og-image'] ?? asset('assets/img/metadata/featured_image/image.png');
    $keywords = trim(($m['keyword'] ?? '') . ' ' . config('metadata.keyword'));
@endphp
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta('title') }}</title>
    <meta name="description" content="{{ strip_tags($meta('description')) }}">
    @if ($keywords !== '')
        <meta name="keywords" content="{{ $keywords }}">
    @endif
    <meta name="robots" content="{{ $m['robots'] ?? 'index, follow' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/metadata/favicon/icon.ico') }}" type="image/x-icon">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $meta('og-title') }}">
    <meta property="og:description" content="{{ strip_tags($meta('og-description')) }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site-name" content="{{ $meta('og-site-name') }}">
    <meta property="og:type" content="{{ $meta('og-type') ?: 'website' }}">
    <meta property="og:locale" content="en_US">

    {{-- Twitter / WhatsApp --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta('og-title') }}">
    <meta name="twitter:description" content="{{ strip_tags($meta('og-description')) }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    @if (config('metadata.google_site_verification'))
        <meta name="google-site-verification" content="{{ config('metadata.google_site_verification') }}">
    @endif

    {{-- JSON-LD (homepage) --}}
    @if (!empty($m['schema']))
        <script type="application/ld+json">{!! json_encode($m['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endif

    {{-- GSAP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    {{-- Swiper.js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    {{-- CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('header_asset')
</head>