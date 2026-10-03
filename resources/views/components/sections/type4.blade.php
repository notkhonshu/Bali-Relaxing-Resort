@php
    $tag_title   = $section_data['tag_title'] ?? 'h2';
    $startSecond = ($section_data['background'] ?? null) === 'bg-background-secondary';

    $items = collect($section_data['items'] ?? [])
        ->map(fn ($item) => [
            'eyebrow'     => trim((string) ($item['eyebrow'] ?? '')),
            'title'       => trim((string) ($item['title'] ?? '')),
            'description' => trim((string) ($item['description'] ?? '')),
            'img'         => [
                'url' => $item['img']['url'] ?? '',
                'alt' => $item['img']['alt'] ?? ($item['title'] ?? ''),
            ],
            'meta'        => collect($item['meta'] ?? [])
                ->filter(fn ($row) => filled($row['value'] ?? ''))
                ->values(),
            'amenities'   => collect($item['amenities'] ?? [])->filter()->values(),
            'url'         => $item['url']['link'] ?? null,
            'cta'         => $item['url']['text'] ?? 'Book Now',
        ])
        ->filter(fn ($item) => $item['title'] !== '')
        ->values();
@endphp

@foreach ($items as $item)
    @php
        $isSecondary = (($loop->index % 2) === 0) === $startSecond;
    @endphp

    <section id="{{ $section_data['id'] ?? '' }}-{{ $loop->iteration }}" class="section-type-4 section {{ $isSecondary ? 'bg-background-secondary' : 'bg-background' }}">
        <div class="max-w-7xl mx-auto px-7">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-9 md:gap-16 items-center">
                <div class="aspect-[3/4] bg-border overflow-hidden {{ $isSecondary ? 'md:order-2' : '' }}">
                    @if (filled($item['img']['url']))
                        <img src="{{ $item['img']['url'] }}" alt="{{ $item['img']['alt'] }}" loading="lazy" class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="min-w-0 {{ $isSecondary ? 'md:order-1' : '' }}">
                    @if ($item['eyebrow'] !== '')
                        <p class="font-heading italic text-fluid-lead text-muted mb-2">{{ $item['eyebrow'] }}</p>
                    @endif

                    <{!! $tag_title !!} class="font-heading text-fluid-h2 mb-5">
                        {{ $item['title'] }}
                    </{!! $tag_title !!}>

                    @if ($item['meta']->isNotEmpty())
                        <ul class="flex flex-wrap gap-x-6 gap-y-1 mb-5 text-fluid-body">
                            @foreach ($item['meta'] as $row)
                                <li>
                                    <span class="text-muted">{{ $row['label'] }}</span>
                                    <span class="font-heading italic text-primary ml-1">{{ $row['value'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($item['description'] !== '')
                        <p class="text-fluid-body text-muted">{{ $item['description'] }}</p>
                    @endif

                    @if ($item['amenities']->isNotEmpty())
                        <ul class="flex flex-wrap gap-2 mt-5">
                            @foreach ($item['amenities'] as $amenity)
                                <li class="border border-theme px-3 py-1 text-fluid-body text-muted">{{ $amenity }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($item['url'])
                        <a href="{{ $item['url'] }}" class="btn btn-outline inline-block mt-6">
                            {{ $item['cta'] }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endforeach