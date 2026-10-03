@php
    $tag_title   = $section_data['tag_title'] ?? 'h2';
    $eyebrow     = $section_data['eyebrow'] ?? null;
    $title       = $section_data['title'] ?? '';
    $description = $section_data['description'] ?? null;
    $cta         = $section_data['cta'] ?? null;
    $images      = $section_data['images'] ?? [];
@endphp

<section id="{{ $section_data['id'] ?? '' }}" class="section-type-2 section bg-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-7">
        <div class="grid grid-cols-1 md:grid-cols-[2fr_3fr] gap-8 md:gap-14 pb-14">
            <div class="min-w-0">
                @if ($eyebrow)
                    <p class="font-heading italic text-fluid-lead text-on-media mb-2">{{ $eyebrow }}</p>
                @endif
                <{!! $tag_title !!} class="font-heading text-fluid-h2 mb-6 text-on-media">
                    {{ $title }}
                </{!! $tag_title !!}>
            </div>
            <div class="min-w-0">
                @if ($description)
                    <p class="text-fluid-body text-on-media text-left md:text-justify">{{ $description }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @for ($i = 0; $i < 3; $i++)
                <div class="min-w-0 aspect-[3/4] bg-border overflow-hidden">
                    @if (!empty($images[$i]['url']))
                        <img src="{{ $images[$i]['url'] }}" alt="{{ $images[$i]['alt'] ?? $title }}" loading="lazy" class="w-full h-full object-cover">
                    @endif
                </div>
            @endfor
        </div>
    </div>
</section>