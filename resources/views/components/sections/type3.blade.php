@php
    $tag_title = $section_data['tag_title'] ?? 'h2';
    $eyebrow   = $section_data['eyebrow'] ?? null;
    $title     = $section_data['title'] ?? null;

    $rooms = collect($section_data['rooms'] ?? [])->map(fn ($room) => [
        'title'       => $room['title'] ?? '',
        'sized'       => $room['sized'] ?? '',
        'total'       => $room['total'] ?? '',
        'description' => $room['description'] ?? '',
        'img'         => [
            'url' => $room['img']['url'] ?? '',
            'alt' => $room['img']['alt'] ?? ($room['title'] ?? ''),
        ],
        'url'         => $room['url']['link'] ?? null,
        'cta'         => $room['url']['text'] ?? 'Discover More',
    ])->values();

    $first = $rooms->first();
@endphp

@if ($first)
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-3 bg-background-secondary py-24" data-type3 data-rooms="{{ $rooms->toJson() }}">
        <div class="max-w-7xl mx-auto px-7">
            @if ($eyebrow || $title)
                <div class="max-w-2xl mb-12">
                    @if ($eyebrow)
                        <p class="font-heading italic text-fluid-lead text-muted mb-2">{{ $eyebrow }}</p>
                    @endif
                    @if ($title)
                        <{!! $tag_title !!} class="text-fluid-h2">
                            {{ $title }}
                        </{!! $tag_title !!}>
                    @endif
                </div>
            @endif

            <div data-type3-feature class="grid grid-cols-1 md:grid-cols-[3fr_2fr] gap-9 items-center mb-8">
                <div class="relative aspect-[16/11] bg-background-secondary overflow-hidden">
                    <img data-feature="img" src="{{ $first['img']['url'] }}" alt="{{ $first['img']['alt'] }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 data-feature="title" class="text-fluid-h2 mb-2">{{ $first['title'] }}</h3>
                    <p data-feature="subtitle" class="font-heading italic text-fluid-lead text-primary mb-4">Sized {{ $first['sized'] }} | Total Rooms: {{ $first['total'] }}</p>
                    <p data-feature="description" class="text-fluid-body text-light">{{ $first['description'] }}</p>
                    <a data-feature="cta" href="{{ $first['url'] ?? '#' }}" class="{{ $first['url'] ? '' : 'hidden' }} inline-block mt-6 px-6 py-3 text-fluid-small tracking-[0.09em] border border-[var(--color-primary)] text-[var(--color-primary)] transition-colors duration-300 hover:bg-[var(--color-primary)] hover:text-white">
                        {{ $first['cta'] }}
                    </a>
                </div>
            </div>

            <div data-type3-list>
                <div data-type3-slider class="swiper">
                    <div data-type3-wrapper class="swiper-wrapper [--swiper-wrapper-transition-timing-function:cubic-bezier(0.22,1,0.36,1)]"></div>
                </div>
            </div>

            <template data-type3-template>
                <button type="button" data-type3-item class="swiper-slide h-auto text-left group cursor-pointer">
                    <div class="aspect-square bg-background-secondary overflow-hidden mb-3">
                        <img data-item="img" src="" alt="" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <span data-item="title" class="block font-heading text-fluid-lead text-[var(--color-text)]"></span>
                    <span data-item="subtitle" class="block font-heading italic text-fluid-small text-primary"></span>
                </button>
            </template>
        </div>
    </section>
@endif