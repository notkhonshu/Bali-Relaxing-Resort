@php
    $title  = $section_data['title'] ?? 'Location';
    $height = $section_data['height'] ?? 'h-[450px] md:h-[600px]';
    $embed  = trim($section_data['embed'] ?? '');

    if (preg_match('/src=["\']([^"\']+)["\']/i', $embed, $match)) {
        $embed = html_entity_decode($match[1]);
    }

    $host  = parse_url($embed, PHP_URL_HOST) ?: '';
    $valid = str_starts_with($embed, 'https://')
        && (str_ends_with($host, 'google.com') || $host === 'maps.google.com');
@endphp

@if ($valid)
    <section id="{{ $section_data['id'] ?? '' }}" class="section-type-6 section bg-background">
        <div class="max-w-7xl mx-auto px-7">
            <div class="relative w-full {{ $height }} bg-border overflow-hidden">
                <iframe src="{{ $embed }}" title="{{ $title }}" class="absolute inset-0 w-full h-full border-0" style="border: 0;" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endif