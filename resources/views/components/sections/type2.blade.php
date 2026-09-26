@php
    $id          = $section_data['id'] ?? null;
    $tag_title   = $section_data['tag_title'] ?? 'h2';
    $eyebrow     = $section_data['eyebrow'] ?? null;
    $title       = $section_data['title'] ?? '';
    $description = $section_data['description'] ?? null;
    $cta         = $section_data['cta'] ?? null;
    $images      = $section_data['images'] ?? [];
@endphp

<section id="{{ $id }}" class="section-type-2 bg-background pt-24 h-screen">
    <div class="max-w-7xl mx-auto px-7">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-14 pb-14">
            <div>
                @if ($eyebrow)
                    <p class="font-heading italic text-[var(--color-text-light)] mb-2">{{ $eyebrow }}</p>
                @endif
                <{!! $tag_title !!} class="text-3xl md:text-4xl mb-6">
                    {{ $title }}
                </{!! $tag_title !!}>
            </div>
            <div>
                @if ($description)
                    <p class="text-light text-justify">{{ $description }}</p>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0.5 bg-border">
            @for ($i = 0; $i < 3; $i++)
                <div class="aspect-[3/4] bg-section">
                    @if (!empty($images[$i]['url']))
                        <img src="{{ $images[$i]['url'] }}" alt="{{ $images[$i]['alt'] ?? $title }}" class="w-full h-full object-cover">
                    @endif
                </div>
            @endfor
        </div>
    </div>
</section>