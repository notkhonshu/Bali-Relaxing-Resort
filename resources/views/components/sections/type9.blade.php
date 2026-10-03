@php
    $tag_title = $section_data['tag_title'] ?? 'h2';
    $eyebrow   = $section_data['eyebrow'] ?? null;
    $title     = $section_data['title'] ?? null;
    $more      = $section_data['more'] ?? null;

    $items = collect($section_data['items'] ?? [])
        ->map(fn ($item) => [
            'title' => trim((string) ($item['title'] ?? '')),
            'img'   => $item['img'] ?? '',
            'url'   => $item['url'] ?? null,
        ])
        ->filter(fn ($item) => $item['title'] !== '' && filled($item['url']))
        ->values();
@endphp

@if ($items->isNotEmpty())
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-9 section bg-background">
        <div class="max-w-7xl mx-auto px-7">
            @if ($eyebrow || $title || !empty($more['link']))
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-12">
                    <div class="min-w-0">
                        @if ($title)
                            <{!! $tag_title !!} class="font-heading text-fluid-h2">
                                {{ $title }}
                            </{!! $tag_title !!}>
                        @endif
                    </div>
                    @if (!empty($more['link']))
                        <a href="{{ $more['link'] }}" class="text-fluid-body text-primary hover:text-primary-hover transition-colors duration-300 shrink-0">
                            {{ $more['text'] ?? 'View All' }}
                        </a>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($items as $item)
                    <a href="{{ $item['url'] }}" class="group block">
                        <div class="aspect-[4/5] overflow-hidden bg-border">
                            @if (filled($item['img']))
                                <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" loading="lazy"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                        </div>
                        <h3 class="font-heading text-fluid-lead mt-4 group-hover:text-primary transition-colors duration-300">
                            {{ $item['title'] }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif