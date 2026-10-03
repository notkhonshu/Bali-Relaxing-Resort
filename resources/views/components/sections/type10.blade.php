@php
    $base      = $section_data['id'] ?? 'type10';
    $tag_title = in_array($section_data['tag_title'] ?? 'h2', ['h1', 'h2', 'h3', 'h4', 'p', 'div'], true)
        ? $section_data['tag_title']
        : 'h2';
    $cta       = $section_data['cta'] ?? [];
    $ctaLink   = $cta['link'] ?? null;
    $ctaText   = $cta['text'] ?? 'Inquire now';

    $items = collect($section_data['items'] ?? [])->map(fn ($item) => [
        'title'       => $item['title'] ?? '',
        'description' => $item['description'] ?? '',
        'url'         => [
            'text' => $item['url']['text'] ?? $ctaText,
            'link' => $item['url']['link'] ?? $ctaLink,
        ],
        'images'      => collect($item['images'] ?? [])
            ->map(fn ($image) => [
                'url' => $image['url'] ?? '',
                'alt' => $image['alt'] ?? ($item['title'] ?? ''),
            ])
            ->filter(fn ($image) => $image['url'] !== '')
            ->values()
            ->all(),
    ])->values();

    $first  = $items->first();
    $hasCta = $items->contains(fn ($item) => filled($item['url']['link']));
@endphp

@if ($items->isNotEmpty())
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-10 section bg-background" data-type10>
        <div class="max-w-7xl mx-auto px-7">
            <div class="grid grid-cols-1 lg:grid-cols-[5fr_7fr] gap-16 lg:gap-24 items-start">

                {{-- Track: sticky container, its height is set by JS --}}
                <div class="type10-track hidden lg:block" data-type10-track>
                    <aside class="type10-aside" data-type10-aside>
                        <ul class="type10-list mb-11">
                            @foreach ($items as $item)
                                <li>
                                    <a
                                        href="#{{ $base }}-{{ $loop->iteration }}"
                                        data-type10-link
                                        data-description="{{ $item['description'] }}"
                                        data-cta-link="{{ $item['url']['link'] }}"
                                        data-cta-text="{{ $item['url']['text'] }}"
                                        @if ($loop->first) aria-current="true" @endif
                                        class="type10-link font-heading text-[clamp(1.75rem,3.2vw,2.625rem)] leading-[1.3] {{ $loop->first ? 'is-active' : '' }}"
                                    >
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <p data-type10-excerpt class="text-muted max-w-[40ch] min-h-[5.2em] mb-8">{{ $first['description'] }}</p>

                        @if ($hasCta)
                            <a
                                href="{{ $first['url']['link'] ?: '#' }}"
                                data-type10-cta
                                class="btn btn-outline inline-block {{ filled($first['url']['link']) ? '' : 'hidden' }}"
                            >{{ $first['url']['text'] }}</a>
                        @endif
                    </aside>
                </div>

                {{-- Image column --}}
                <div class="type10-column min-w-0" data-type10-column>
                    @foreach ($items as $item)
                        <section
                            id="{{ $base }}-{{ $loop->iteration }}"
                            data-type10-panel
                            class="type10-panel {{ $loop->last ? '' : 'mb-20 lg:mb-24' }}"
                        >
                            <{!! $tag_title !!} class="font-heading text-3xl mb-3 lg:sr-only">{{ $item['title'] }}</{!! $tag_title !!}>

                            @if ($item['description'])
                                <p class="text-muted mb-6 lg:hidden">{{ $item['description'] }}</p>
                            @endif

                            @if (filled($item['url']['link']))
                                <a href="{{ $item['url']['link'] }}" class="btn btn-outline inline-block mb-6 lg:hidden">{{ $item['url']['text'] }}</a>
                            @endif

                            <div class="grid gap-3.5 md:gap-7 {{ count($item['images']) > 1 ? 'grid-cols-2' : 'grid-cols-1' }}">
                                @foreach ($item['images'] as $image)
                                    <button type="button" data-type10-zoom aria-label="Enlarge {{ $item['title'] }}" class="block w-full cursor-zoom-in">
                                        <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="type10-flyer block w-full h-auto">
                                    </button>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </div>

        <dialog data-type10-lightbox class="type10-lightbox">
            <img src="" alt="">
        </dialog>
    </section>
@endif