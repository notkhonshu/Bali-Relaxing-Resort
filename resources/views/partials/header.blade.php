<head>
    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- Meta Name --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ isset($data['metadata']['description']) ? strip_tags($data['metadata']['description']) : config('metadata.description') }}">
    <meta name="keywords"
        content="{{ isset($data['metadata']['keyword']) ? $data['metadata']['keyword'] . ' ' . config('metadata.keyword') : config('metadata.keyword') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Meta Property OG --}}
    <meta property="og:title"
        content="{{ isset($data['metadata']['og-title']) ? $data['metadata']['og-title'] : config('metadata.og-title') }}">
    <meta property="og:description"
        content="{{ isset($data['metadata']['og-description']) ? strip_tags($data['metadata']['og-description']) : config('metadata.og-description') }}">
    <meta property="og:image" content="{{ asset('assets/img/metadata/featured_image/image.png') }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site-name"
        content="{{ isset($data['metadata']['og-site-name']) ? $data['metadata']['og-site-name'] : config('metadata.og-site-name') }}">
    <meta property="og:type"
        content="{{ isset($data['metadata']['og-type']) ? $data['metadata']['og-type'] : config('metadata.og-type') }}" />
    <meta property="og:longitude"
        content="{{ isset($data['metadata']['og-longitude']) ? $data['metadata']['og-longitude'] : config('metadata.og-longitude') }}">
    <meta property="og:latitude"
        content="{{ isset($data['metadata']['og-latitude']) ? $data['metadata']['og-latitude'] : config('metadata.og-latitude') }}">
    <meta property="og:locality"
        content="{{ isset($data['metadata']['og-locality']) ? $data['metadata']['og-locality'] : config('metadata.og-locality') }}">
    <meta property="og:region"
        content="{{ isset($data['metadata']['og-region']) ? $data['metadata']['og-region'] : config('metadata.og-region') }}">
    <meta property="og:postal-code"
        content="{{ isset($data['metadata']['og-postal-code']) ? $data['metadata']['og-postal-code'] : config('metadata.og-postal-code') }}">
    <meta property="og:country-name"
        content="{{ isset($data['metadata']['og-country-name']) ? $data['metadata']['og-country-name'] : config('metadata.og-country-name') }}">
    <meta property="og:email"
        content="{{ isset($data['metadata']['og-email']) ? $data['metadata']['og-email'] : config('social.customer_service.email') }}">
    <meta property="og:phone_number"
        content="{{ isset($data['metadata']['og-phone-number']) ? $data['metadata']['og-phone-number'] : config('social.customer_service.whatsapp') }}">
    <meta property="og:street-address"
        content="{{ isset($data['metadata']['og-street-address']) ? $data['metadata']['og-street-address'] : config('social.address.name') }}">
    <meta name="google-site-verification" content="J_AppAA0Oz_nGZykqD4iwfHSXTcPY-xTELcIX1JoJck" />
    {{-- Title --}}
    <title>
        {{ isset($data['metadata']['title']) ? $data['metadata']['title'] : config('metadata.title') }}
    </title>

    {{-- Link --}}
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" href="{{ asset('assets/img/metadata/favicon/icon.ico') }}" type="image/x-icon">

    {{--GSAP--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    
    {{-- Css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('header_asset')

</head>
