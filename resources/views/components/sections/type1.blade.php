{{--
    section_data keys:
        id          string  Section id attribute (for anchor links / nav)
        tag_title   string  Heading tag to render, e.g. 'h1' or 'h2'
        title       string  Main wordmark / heading text
        tagline     string  Optional italic line under the title
        background  array   [
                        'type'  => 'image' | 'video' | 'slider',   // default 'image'
                        'image' => ['url' => ..., 'alt' => ...],   // when type = image
                        'video' => ['url' => ...],                 // when type = video
                        'slides' => [                               // when type = slider
                            ['url' => ..., 'alt' => ...],
                            ...
                        ],
                        'autoplay_delay' => 6000,                  // slider only, ms
                    ]
                    Omit entirely to fall back to a plain gradient placeholder.
--}}

@php
    $id        = $section_data['id'] ?? null;
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

<section id="{{ $id }}" class="section-type-1 relative h-screen flex items-center justify-center overflow-hidden">
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
        @endif
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    <div class="relative text-center px-6">
        <{!! $tag_title !!} class="[font-family:var(--font-heading)] font-medium tracking-wide [color:var(--color-white)] text-[clamp(3.2rem,8vw,6rem)] leading-[1.05]">
            {{ $title }}
        </{!! $tag_title !!}>

        @if ($tagline)
            <p class="[font-family:var(--font-heading)] italic [color:var(--color-cream)] opacity-90 text-xl mt-2">
                {{ $tagline }}
            </p>
        @endif
    </div>
</section>