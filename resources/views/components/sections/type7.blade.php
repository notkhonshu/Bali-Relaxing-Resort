@php
    $tag_title = $section_data['tag_title'] ?? 'h2';
    $title     = $section_data['title'] ?? null;

    $images = collect($section_data['images'] ?? [])->map(fn ($image) => [
        'url' => $image['url'] ?? '',
        'alt' => $image['alt'] ?? '',
    ])->filter(fn ($image) => $image['url'] !== '')->values();
@endphp

@if ($images->isNotEmpty())
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-7 section bg-background-secondary" data-type7>
        <div class="max-w-7xl mx-auto px-7">
            @if ($title)
                <{!! $tag_title !!} class="font-heading text-center text-fluid-h2 mb-12">
                    {{ $title }}
                </{!! $tag_title !!}>
            @endif

            <div data-type7-slider data-autoplay-delay="{{ $section_data['autoplay_delay'] ?? 3500 }}" class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($images as $image)
                        <div class="swiper-slide !h-auto">
                            <div class="aspect-[2/3] overflow-hidden bg-border rounded-[var(--radius-sm)] border border-theme">
                                <img
                                    src="{{ $image['url'] }}"
                                    alt="{{ $image['alt'] }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif