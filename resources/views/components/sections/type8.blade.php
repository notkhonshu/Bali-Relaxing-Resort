@php
    $tag_title = $section_data['tag_title'] ?? 'h2';
    $eyebrow   = $section_data['eyebrow'] ?? null;
    $title     = $section_data['title'] ?? '';
    $cta       = $section_data['cta'] ?? null;

    $description = collect((array) ($section_data['description'] ?? []))->filter()->values();
    $amenities   = collect($section_data['amenities'] ?? [])->filter()->values();
    $meta        = collect($section_data['meta'] ?? [])
        ->filter(fn ($row) => filled($row['value'] ?? ''))
        ->values();

    // The excerpt is a lead paragraph, skipped if it duplicates the first description paragraph
    $excerpt = trim((string) ($section_data['excerpt'] ?? ''));
    if ($excerpt !== '' && $excerpt === $description->first()) {
        $excerpt = '';
    }

    $hasRight = $excerpt !== '' || $description->isNotEmpty() || $amenities->isNotEmpty() || !empty($cta['link']);
    $hasLeft  = filled($title) || $meta->isNotEmpty();
@endphp

@if ($hasLeft || $hasRight)
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-8 section bg-background">
        <div class="max-w-7xl mx-auto px-7">
            <div class="grid grid-cols-1 {{ $hasLeft && $hasRight ? 'md:grid-cols-[2fr_3fr]' : '' }} gap-10 md:gap-16">

                @if ($hasLeft)
                    <div class="min-w-0">
                        @if ($eyebrow)
                            <p class="font-heading italic text-fluid-lead text-muted mb-2">{{ $eyebrow }}</p>
                        @endif

                        @if (filled($title))
                            <{!! $tag_title !!} class="font-heading text-fluid-h2 mb-8">
                                {{ $title }}
                            </{!! $tag_title !!}>
                        @endif

                        @if ($meta->isNotEmpty())
                            <dl class="border-t border-theme">
                                @foreach ($meta as $row)
                                    <div class="flex items-baseline justify-between gap-6 py-4 border-b border-theme">
                                        <dt class="text-fluid-body text-muted">{{ $row['label'] }}</dt>
                                        <dd class="font-heading italic text-fluid-body text-primary text-right">{{ $row['value'] }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        @endif
                    </div>
                @endif

                @if ($hasRight)
                    <div class="min-w-0">
                        @if ($excerpt !== '')
                            <p class="font-heading italic text-fluid-lead text-body mb-6">{{ $excerpt }}</p>
                        @endif

                        @foreach ($description as $paragraph)
                            <p class="text-fluid-body text-muted {{ $loop->last ? '' : 'mb-5' }}">{{ $paragraph }}</p>
                        @endforeach

                        @if ($amenities->isNotEmpty())
                            <h3 class="font-heading text-fluid-lead mt-10 mb-4">Room Features</h3>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-8">
                                @foreach ($amenities as $item)
                                    <li class="flex items-center gap-3 py-3 border-b border-theme text-fluid-body text-muted">
                                        <span class="h-1.5 w-1.5 rounded-full bg-primary shrink-0" aria-hidden="true"></span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!empty($cta['link']))
                            <a href="{{ $cta['link'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline inline-block mt-6">
                                {{ $cta['text'] ?? 'Book Now' }}
                            </a>
                        @endif
                        
                        @if (!empty($section_data['form']))
                            <div class="mt-12 pt-8 border-t border-theme">
                                @include('components.sections.type13', ['section_data' => $section_data['form']])
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif