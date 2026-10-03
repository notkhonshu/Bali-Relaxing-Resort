@php
    $tag_title = $section_data['tag_title'] ?? 'h2';
    $title     = $section_data['title'] ?? null;

    $items = collect($section_data['items'] ?? [])->map(fn ($item) => [
        'title'   => $item['title'] ?? '',
        'excerpt' => $item['excerpt'] ?? '',
        'img'     => [
            'url' => $item['img']['url'] ?? '',
            'alt' => $item['img']['alt'] ?? ($item['title'] ?? ''),
        ],
        'url'     => $item['url']['link'] ?? null,
        'cta'     => $item['url']['text'] ?? 'View More',
    ])->values();
@endphp

@if ($items->isNotEmpty())
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-5 relative h-screen max-h-screen overflow-hidden bg-dark" data-type5>
        @if ($title)
            <{!! $tag_title !!} class="sr-only">{{ is_array($title) ? implode(' ', $title) : $title }}</{!! $tag_title !!}>
        @endif

        <div class="absolute inset-0 z-0 touch-pan-y" data-type5-stage>
            @foreach ($items as $item)
                <article data-type5-slide class="absolute inset-0 {{ $loop->first ? '' : 'invisible' }}" @if (! $loop->first) aria-hidden="true" @endif>
                    <img
                        data-type5-img
                        src="{{ $item['img']['url'] }}"
                        alt="{{ $item['img']['alt'] }}"
                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                    <div class="absolute inset-0 bg-dark opacity-40"></div>

                    <div data-type5-content class="absolute inset-x-0 bottom-0 pb-44 md:pb-48">
                        <div class="max-w-7xl mx-auto px-7 flex flex-col gap-6 md:flex-row md:items-end md:justify-between md:gap-12">
                            <div>
                                <h3 class="font-heading text-fluid-h1 text-on-media">
                                    {{ $item['title'] }}
                                </h3>

                                @if ($item['url'])
                                    <a href="{{ $item['url'] }}" class="btn btn-outline-light inline-block mt-8">
                                        {{ $item['cta'] }}
                                    </a>
                                @endif
                            </div>

                            @if ($item['excerpt'])
                                <p class="text-fluid-body text-on-media md:max-w-sm lg:max-w-md shrink-0">
                                    {{ $item['excerpt'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="absolute inset-0 z-20 pointer-events-none">
            <div class="absolute inset-x-0 bottom-0 pb-8">
                <div class="max-w-7xl mx-auto px-7">
                    <p data-type5-counter class="font-heading italic text-fluid-small text-on-media text-right mb-4">{{ sprintf('%02d / %02d', 1, $items->count()) }}</p>

                    <div class="flex gap-3 md:gap-4 pointer-events-auto">
                        @foreach ($items as $item)
                            <button type="button" data-type5-tab aria-label="{{ $item['title'] }}" class="index-tab flex-1 pt-3 text-left cursor-pointer {{ $loop->first ? 'is-active' : '' }}">
                                <span class="hidden md:block font-heading italic text-fluid-small">{{ $item['title'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif