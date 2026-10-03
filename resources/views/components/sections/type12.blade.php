@php
    $images = collect($section_data['images'] ?? [])
        ->filter(fn ($image) => filled($image['url'] ?? ''))
        ->values();
@endphp

@if ($images->isNotEmpty())
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-12 section bg-background" data-type12>
        <div class="max-w-7xl mx-auto px-7">
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 md:gap-6">
                @foreach ($images as $image)
                    <li>
                        <button
                            type="button"
                            data-type12-item
                            data-index="{{ $loop->index }}"
                            aria-label="Open photo {{ $loop->iteration }} of {{ $images->count() }}"
                            class="block w-full aspect-[4/3] overflow-hidden bg-border cursor-zoom-in group"
                        >
                            <img
                                src="{{ $image['url'] }}"
                                alt="{{ $image['alt'] ?? '' }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            >
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <dialog data-type12-lightbox aria-label="Photo viewer" class="m-auto p-0 bg-transparent max-w-[92vw] max-h-[92vh] backdrop:bg-black/85">
            <img data-type12-image src="" alt="" class="block max-w-[92vw] max-h-[88vh] object-contain">

            <p data-type12-counter class="absolute left-0 right-0 -bottom-8 text-center text-white text-fluid-body" aria-live="polite"></p>

            <button type="button" data-type12-close aria-label="Close" class="absolute top-3 right-3 w-11 h-11 flex items-center justify-center bg-black/50 text-white hover:bg-black/70 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>

            <button type="button" data-type12-prev aria-label="Previous photo" class="absolute left-3 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center bg-black/50 text-white hover:bg-black/70 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15 5L8 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <button type="button" data-type12-next aria-label="Next photo" class="absolute right-3 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center bg-black/50 text-white hover:bg-black/70 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </dialog>
    </section>
@endif