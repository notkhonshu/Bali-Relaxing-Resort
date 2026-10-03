@php
    $addressLines = $footer['address_lines'] ?? [];
    $mapUrl       = $footer['map_url'] ?? '';
    $explore      = $footer['explore'] ?? [];
    $rooms        = $footer['rooms'] ?? [];
    $facilities   = $footer['facilities'] ?? [];
    $hotelNews    = $footer['hotel_news'] ?? [];
    $socials      = $footer['socials'] ?? [];
    $bookUrl      = $footer['book_url'] ?? '';

    $hasEmail   = filled($footer['email'] ?? '');
    $hasWa      = filled($footer['whatsapp'] ?? '') && filled($footer['whatsapp_url'] ?? '');
    $hasTel     = filled($footer['tel'] ?? '') && filled($footer['tel_url'] ?? '');
    $hasContact = $hasEmail || $hasWa || $hasTel;

    $headingClass = 'mb-3 text-fluid-body uppercase tracking-[0.16em] text-white/50';
@endphp

<footer class="site-footer bg-dark text-on-media font-body font-light overflow-hidden">
    <div class="max-w-7xl mx-auto px-7 pt-20 md:pt-28">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-[1.2fr_1.2fr_1fr] gap-10 md:gap-8">
            <div>
                @if (count($addressLines) || filled($mapUrl))
                    <p class="{{ $headingClass }}">Visit</p>

                    @if (count($addressLines))
                        <address class="not-italic text-fluid-body text-white/90">
                            @foreach ($addressLines as $line)
                                {{ $line }}<br>
                            @endforeach
                        </address>
                    @endif

                    @if (filled($mapUrl))
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer"
                           class="f-link mt-2 text-fluid-body text-accent">View on map</a>
                    @endif
                @endif
            </div>

            <div>
                @if ($hasContact)
                    <p class="{{ $headingClass }}">Contact</p>

                    <ul class="footer-contact flex flex-col items-start text-fluid-body text-white/90">
                        @if ($hasEmail)
                            <li>
                                <a href="{{ $footer['email_url'] }}" class="f-link text-fluid-body">{{ $footer['email'] }}</a>
                            </li>
                        @endif

                        @if ($hasWa)
                            <li>
                                <a href="{{ $footer['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer"
                                   class="f-link text-fluid-body">WhatsApp: {{ $footer['whatsapp'] }}</a>
                            </li>
                        @endif

                        @if ($hasTel)
                            <li>
                                <a href="{{ $footer['tel_url'] }}" class="f-link text-fluid-body">{{ $footer['tel'] }}</a>
                            </li>
                        @endif
                    </ul>
                @endif

                @if (filled($bookUrl))
                    <a href="{{ $bookUrl }}" target="_blank" rel="noopener noreferrer"
                       class="mt-5 inline-block border border-white/30 px-5 py-2.5 text-fluid-body uppercase tracking-[0.16em] text-white transition hover:bg-white hover:text-black">
                        Book Now
                    </a>
                @endif
            </div>
            <nav aria-label="Explore">
                @if (count($explore))
                    <p class="{{ $headingClass }}">Explore</p>
                    <div class="flex flex-col items-start">
                        @foreach ($explore as $link)
                            <a href="{{ $link['url'] }}" class="f-link text-fluid-body">{{ $link['title'] }}</a>
                        @endforeach
                    </div>
                @endif
            </nav>
        </div>

        @if (count($rooms) || count($facilities) || count($hotelNews))
            <div class="mt-12 md:mt-14 pt-10 border-t border-white/15 grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8">
                @if (count($rooms))
                    <nav aria-label="Accommodation">
                        <p class="{{ $headingClass }}">Accommodation</p>
                        <div class="flex flex-col items-start">
                            @foreach ($rooms as $room)
                                <a href="{{ $room['url'] }}" class="f-link text-fluid-body">{{ $room['title'] }}</a>
                            @endforeach
                        </div>
                        <a href="{{ $footer['rooms_url'] }}" class="f-link mt-2 text-fluid-body text-accent">View all rooms</a>
                    </nav>
                @endif

                @if (count($facilities))
                    <nav aria-label="Our Facility">
                        <p class="{{ $headingClass }}">Our Facility</p>
                        <div class="flex flex-col items-start">
                            @foreach ($facilities as $facility)
                                <a href="{{ $facility['url'] }}" class="f-link text-fluid-body">{{ $facility['title'] }}</a>
                            @endforeach
                        </div>
                        <a href="{{ $footer['facilities_url'] }}" class="f-link mt-2 text-fluid-body text-accent">View all facilities</a>
                    </nav>
                @endif

                @if (count($hotelNews))
                    <nav aria-label="Hotel News">
                        <p class="{{ $headingClass }}">Hotel News</p>
                        <div class="flex flex-col items-start">
                            @foreach ($hotelNews as $news)
                                <a href="{{ $news['url'] }}" class="f-link text-fluid-body">{{ $news['title'] }}</a>
                            @endforeach
                        </div>
                    </nav>
                @endif
            </div>
        @endif

        <div class="mt-14 md:mt-16 pt-5 border-t border-white/15 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <p class="text-fluid-body text-white/50">
                &copy; {{ date('Y') }} {{ $addressLines[0] ?? config('app.name') }}
            </p>

            <div class="flex justify-end gap-5">
            @if (count($socials))
                <ul class="footer-social flex items-center gap-3">
                    @foreach ($socials as $social)
                        <li>
                            <a href="{{ $social['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="{{ $social['title'] }}"
                            title="{{ $social['title'] }}"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-white/25 text-white/80 transition hover:border-white hover:text-white">
                                <i class="ti {{ $social['icon'] }} text-fluid-body"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
            <p class="flex items-center gap-2 text-fluid-body tracking-[0.08em] text-white/70"> 
                <span class="h-1.5 w-1.5 rounded-full bg-primary" aria-hidden="true"></span>
                Bali
                <time data-footer-clock datetime="{{ now('Asia/Makassar')->format('H:i') }}">{{ now('Asia/Makassar')->format('H:i') }}</time>
                WITA
            </p>
            </div>
        </div>

        <div class="f-wordmark mt-8 md:mt-10" aria-hidden="true">
            <span class="f-wordmark-main">{{ config('app.name') }}</span>
            <span class="f-wordmark-sub">Resort &amp; Spa</span>
        </div>
</footer>