@php
    $tag_title = in_array($section_data['tag_title'] ?? 'h2', ['h1', 'h2', 'h3', 'h4', 'p', 'div'], true)
        ? $section_data['tag_title']
        : 'h2';

    $breadcrumbs = collect($section_data['breadcrumbs'] ?? [])->filter(fn ($b) => filled($b['title'] ?? ''))->values();
    $eyebrow     = trim((string) ($section_data['eyebrow'] ?? ''));
    $title       = trim((string) ($section_data['title'] ?? ''));
    $excerpt     = trim((string) ($section_data['excerpt'] ?? ''));
    $image       = $section_data['image'] ?? null;
    $paragraphs  = collect($section_data['description'] ?? [])->filter()->values();
    $cta         = $section_data['cta'] ?? null;
    $prev        = $section_data['prev'] ?? null;
    $next        = $section_data['next'] ?? null;
@endphp

@if ($title !== '')
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-11 section bg-background">
        <div class="max-w-7xl mx-auto px-7">

            @if ($breadcrumbs->isNotEmpty())
                <nav aria-label="Breadcrumb" class="mb-7">
                    <ol class="flex flex-wrap items-center gap-x-2.5 gap-y-1 text-fluid-body text-muted">
                        @foreach ($breadcrumbs as $crumb)
                            <li class="flex items-center gap-2.5">
                                @if (filled($crumb['url'] ?? null))
                                    <a href="{{ $crumb['url'] }}" class="hover:text-primary transition-colors duration-200">{{ $crumb['title'] }}</a>
                                    <span aria-hidden="true">/</span>
                                @else
                                    <span aria-current="page" class="text-body">{{ $crumb['title'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            @if ($eyebrow !== '')
                <p class="font-heading italic text-fluid-lead text-primary mb-2">{{ $eyebrow }}</p>
            @endif

            <{!! $tag_title !!} class="font-heading text-fluid-h2 mb-6">{{ $title }}</{!! $tag_title !!}>

            @if ($excerpt !== '')
                <p class="text-fluid-lead text-muted font-light mb-10">{{ $excerpt }}</p>
            @endif

            @if ($image && filled($image['url'] ?? ''))
                <figure class="mb-12 lg:-mx-20">
                    <img
                        src="{{ $image['url'] }}"
                        alt="{{ $image['alt'] ?? $title }}"
                        loading="lazy"
                        class="w-full aspect-[16/10] object-cover bg-border"
                    >
                </figure>
            @endif

            @if ($paragraphs->isNotEmpty())
                <div class="space-y-6 text-fluid-body text-muted leading-[1.85]">
                    @foreach ($paragraphs as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            @endif

            @if (!empty($cta['link']))
                <div class="mt-12 pt-8 border-t border-theme">
                    <a href="{{ $cta['link'] }}" class="btn btn-outline inline-block">
                        {{ $cta['text'] ?? 'Inquire Now' }}
                    </a>
                </div>
            @endif

            @if ($prev || $next)
                <nav aria-label="More articles" class="mt-16 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @if ($prev)
                        <a href="{{ $prev['url'] }}" rel="prev" class="block border border-theme p-6 hover:border-primary transition-colors duration-200">
                            <span class="block text-fluid-body text-muted">← Previous</span>
                            <span class="block mt-2 font-heading text-xl leading-snug">{{ $prev['title'] }}</span>
                        </a>
                    @endif

                    @if ($next)
                        <a href="{{ $next['url'] }}" rel="next" class="block border border-theme p-6 text-right hover:border-primary transition-colors duration-200 {{ $prev ? '' : 'sm:col-start-2' }}">
                            <span class="block text-fluid-body text-muted">Next →</span>
                            <span class="block mt-2 font-heading text-xl leading-snug">{{ $next['title'] }}</span>
                        </a>
                    @endif
                </nav>
            @endif
        </div>
    </section>
@endif