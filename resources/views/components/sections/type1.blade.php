@php
    $tag_title = $section_data['tag_title'] ?? 'h1';
    $title     = $section_data['title'] ?? '';
    $tagline   = $section_data['tagline'] ?? null;

    $background = $section_data['background'] ?? null;
    $bgType     = $background['type'] ?? 'image';

    $videoUrl = is_array($background['video'] ?? null)
        ? ($background['video']['url'] ?? null)
        : ($background['video'] ?? null);

    $imageData = $background['image'] ?? null;
    $imageUrl  = is_array($imageData) ? ($imageData['url'] ?? null) : $imageData;
    $imageAlt  = is_array($imageData) ? ($imageData['alt'] ?? $title) : $title;
@endphp

<section id="{{ $section_data['id'] ?? '' }}" class="section-type-1 relative h-screen flex items-center justify-center overflow-hidden bg-dark">
    <div class="absolute inset-0">
        @if ($bgType === 'video' && !empty($videoUrl))
            <video class="w-full h-full object-cover" src="{{ $videoUrl }}" autoplay muted loop playsinline></video>
        @elseif ($bgType === 'slider' && !empty($background['slides']))
            <div class="swiper heroSwiper w-full h-full" data-autoplay-delay="{{ $background['autoplay_delay'] ?? 6000 }}">
                <div class="swiper-wrapper">
                    @foreach ($background['slides'] as $slide)
                        <div class="swiper-slide">
                            <img src="{{ is_array($slide) ? ($slide['url'] ?? '') : $slide }}" alt="{{ is_array($slide) ? ($slide['alt'] ?? $title) : $title }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var el = document.currentScript.previousElementSibling;
                    if (window.Swiper && el && !el.swiper) {
                        new Swiper(el, {
                            loop: true,
                            effect: 'fade',
                            autoplay: { delay: Number(el.dataset.autoplayDelay) || 6000 },
                        });
                    }
                });
            </script>
        @elseif (!empty($imageUrl))
            <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-dark opacity-40"></div>
    </div>

    <div class="relative text-center px-6">
        <{!! $tag_title !!} class="font-heading font-medium text-on-media text-fluid-display">
            {{ $title }}
        </{!! $tag_title !!}>

        @if ($tagline)
            <p class="font-heading font-medium italic text-accent text-fluid-h3 mt-2">
                {{ $tagline }}
            </p>
        @endif
    </div>
</section>