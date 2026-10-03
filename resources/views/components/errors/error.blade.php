@extends('layouts.main')

@php
    $status = (int) ($status ?? 500);
    $site   = config('app.name');

    $messages = [
        400 => ['Bad Request',          'We could not understand that request. Please go back and try again.'],
        401 => ['Sign In Required',     'You need to sign in to view this page.'],
        403 => ['Access Denied',        'You do not have permission to view this page.'],
        404 => ['Page Not Found',       "The page you are looking for may have moved or no longer exists. Let us guide you back to {$site}."],
        405 => ['Method Not Allowed',   'This action is not allowed for this page. Please go back and try again.'],
        408 => ['Request Timeout',      'The request took too long. Please try again.'],
        419 => ['Page Expired',         'Your session has expired. Please go back, refresh the page, and try again.'],
        429 => ['Too Many Requests',    'You have made too many requests. Please wait a moment and try again.'],
        500 => ['Something Went Wrong', 'An unexpected error occurred on our side. Please try again in a few minutes, or contact us directly if you need to book right away.'],
        502 => ['Bad Gateway',          'We are having trouble reaching our server. Please try again in a few minutes.'],
        503 => ['We’ll Be Right Back',  'Our website is undergoing scheduled maintenance. Please check back soon, or contact us directly for reservations.'],
        504 => ['Gateway Timeout',      'Our server took too long to respond. Please try again in a few minutes.'],
    ];

    [$heading, $message] = $messages[$status]
        ?? ($status >= 500
            ? $messages[500]
            : ['Something Went Wrong', 'We could not complete your request. Please go back and try again.']);

    $seo = \App\Support\Seo::make($heading, $message, null, ['robots' => 'noindex, nofollow']);

    $links = [
        ['title' => 'Accommodation', 'url' => route('room.index')],
        ['title' => 'Facility',      'url' => route('facility.index')],
        ['title' => 'Promotion',     'url' => route('page', 'promotion')],
        ['title' => 'Hotel News',    'url' => route('hotel-news.index')],
    ];

    $image = \App\Support\DetailPage::image(config('data.rooms.0.feature_image'));
@endphp

@section('content')
    {{-- Pita gelap supaya navbar putih tetap terbaca di halaman terang.
         Hapus jika navbar Anda sudah punya background sendiri. --}}
    <div class="bg-dark h-24 md:h-28"></div>

    <main class="bg-background-secondary font-body text-body">
        <div class="mx-auto grid max-w-[1180px] items-center gap-10 px-6 py-[var(--section-padding-mobile)] md:grid-cols-2 md:gap-24 md:px-[72px] md:py-[var(--section-padding)]">
            <div class="aspect-[4/5] w-full max-w-[460px] overflow-hidden bg-border">
                @if ($image)
                    <img src="{{ $image }}" alt="{{ $site }}" class="h-full w-full object-cover">
                @endif
            </div>

            <section class="flex flex-col items-start gap-3.5">
                <span class="font-heading italic text-light">Error {{ $status }}</span>
                <h1 class="font-heading text-fluid-display text-primary font-normal">{{ $status }}</h1>
                <h2 class="font-heading text-fluid-h2 text-body font-normal">{{ $heading }}</h2>
                <p class="text-fluid-body text-light max-w-[460px]">{{ $message }}</p>

                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <a href="{{ route('index') }}"
                       class="inline-flex min-h-12 items-center border border-primary px-8 text-[13px] uppercase tracking-[0.12em] text-primary transition-colors duration-300 hover:bg-primary hover:text-on-media">
                        Back to Home
                    </a>
                    <a href="{{ route('page', 'contact-us') }}"
                       class="inline-flex min-h-12 items-center px-4 text-light underline underline-offset-4 hover:text-primary">
                        Contact Us
                    </a>
                </div>
            </section>
        </div>

        {{-- Menu --}}
        <nav aria-label="Continue exploring" class="mx-auto max-w-[1180px] px-6 pb-[var(--section-padding-mobile)] md:px-[72px] md:pb-[var(--section-padding)]">
            <ul class="grid grid-cols-2 gap-6 border-t border-theme md:grid-cols-4">
                @foreach ($links as $link)
                    <li class="pt-5">
                        <a href="{{ $link['url'] }}" class="group flex flex-col gap-1.5">
                            <span class="font-heading text-body text-xl transition-colors group-hover:text-primary">{{ $link['title'] }}</span>
                            <span class="font-heading text-primary text-sm italic">Discover More</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </main>
@endsection