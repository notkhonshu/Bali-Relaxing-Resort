<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DetailPage
{
    private const PLACEHOLDER = 'assets/img/static/lazy/placeholder.png';

    public static function room(array $room, Collection $all): array
    {
        $title = self::text($room['title'] ?? '');

        return [
            'title'       => $title,
            'eyebrow'     => 'Accommodation',
            'cover'       => self::image($room['feature_image'] ?? null),
            'excerpt'     => self::text($room['excerpt'] ?? ''),
            'description' => self::list($room['description'] ?? []),
            'meta'        => self::meta([
                'Room Size'   => $room['size'] ?? '',
                'Total Rooms' => $room['total_room'] ?? '',
            ]),
            'amenities'   => self::list($room['amenities'] ?? []),
            'gallery'     => self::gallery($room['galleries'] ?? $room['gallery'] ?? [], $title),
            'cta'         => self::cta('Book Now', config('socials.book_url')),

            'related_eyebrow' => 'Continue Exploring',
            'related_title'   => 'Other Rooms',
            'related_more'    => ['text' => 'View All Rooms', 'link' => route('room.index')],
            'related'         => self::related(
                $all->where('slug', '!=', $room['slug'] ?? null),
                'feature_image',
                'room.detail'
            ),
        ];
    }

    public static function facility(array $item, Collection $all): array
    {
        $title    = self::text($item['title'] ?? '');
        $category = ucfirst(self::text(Arr::first(Arr::wrap($item['categories'] ?? ''))));

        return [
            'title'       => $title,
            'eyebrow'     => $category ?: 'Facility',
            'cover'       => self::image($item['feature_images'] ?? null),
            'excerpt'     => self::text($item['excerpt'] ?? ''),
            'description' => self::list($item['description'] ?? []),
            'meta'        => self::meta([
                'Opening Hours' => $item['open_time'] ?? '',
                'Category'      => $category,
            ]),
            'amenities'   => self::list($item['amenities'] ?? []),
            'gallery'     => self::gallery($item['gallery'] ?? $item['galleries'] ?? [], $title),
            'cta'         => self::cta('Make a Reservation', $item['url'] ?? ''),

            'related_eyebrow' => 'Continue Exploring',
            'related_title'   => 'Other Facilities & Activities',
            'related_more'    => ['text' => 'View All Facilities & Activities', 'link' => route('facility.index')],
            'related'         => self::related(
                $all->where('slug', '!=', $item['slug'] ?? null),
                'feature_images',
                'facility.detail'
            ),
        ];
    }

    public static function eventActivity(array $item, Collection $all): array
    {
        $title = self::text($item['title'] ?? '');

        return [
            'title'       => $title,
            'eyebrow'     => 'Event Activity',
            'cover'       => self::image($item['images'] ?? null),
            'excerpt'     => self::text($item['excerpt'] ?? ''),
            'description' => self::list($item['description'] ?? []),
            'meta'        => [],
            'amenities'   => [],
            'gallery'     => self::gallery($item['gallery'] ?? [], $title),
            'cta'         => self::cta('Inquire Now', route('page', 'contact-us')),

            'related_eyebrow' => 'Continue Exploring',
            'related_title'   => 'Other Events & Activities',
            'related_more'    => ['text' => 'View All Events & Activities', 'link' => route('event-activity.index')],
            'related'         => self::related(
                $all->where('slug', '!=', $item['slug'] ?? null),
                'images',
                'event-activity.detail'
            ),
        ];
    }

    public static function whatsNew(array $item, Collection $all): array
    {
        $title = self::text($item['title'] ?? '');
        $list  = $all->values();
        $index = $list->search(fn ($i) => ($i['slug'] ?? null) === ($item['slug'] ?? null));

        $neighbor = function (int $step) use ($list, $index) {
            if ($index === false || $list->count() < 2) {
                return null;
            }

            $n = $list->get(($index + $step + $list->count()) % $list->count());

            return filled($n['title'] ?? '') && filled($n['slug'] ?? '')
                ? ['title' => self::text($n['title']), 'url' => route('whats-new.detail', $n['slug'])]
                : null;
        };

        return [
            'title'       => $title,
            'eyebrow'     => 'What’s New',
            'cover'       => self::image($item['images'] ?? null),
            'excerpt'     => self::text($item['excerpt'] ?? ''),
            'description' => self::list($item['description'] ?? []),
            'cta'         => self::cta('Inquire Now', route('page', 'contact-us')),
            'breadcrumbs' => [
                ['title' => 'Hotel News', 'url' => route('hotel-news.index')],
                ['title' => 'What’s New', 'url' => route('whats-new.index')],
                ['title' => $title,       'url' => null],
            ],
            'prev'        => $neighbor(-1),
            'next'        => $neighbor(1),

            'related_title' => 'Other News',
            'related_more'  => ['text' => 'View All News', 'link' => route('whats-new.index')],
            'related'       => self::related(
                $all->where('slug', '!=', $item['slug'] ?? null),
                'images',
                'whats-new.detail'
            ),
        ];
    }

    public static function contact(): array
    {
        $address = config('socials.address', []);
        $cs      = config('socials.customer_service', []);

        $addressLine = collect([
            $address['name'] ?? '',
            $address['street'] ?? '',
            trim(($address['locality'] ?? '') . ' ' . ($address['postal_code'] ?? '')),
        ])->map(fn ($v) => self::text($v))->filter()->implode(', ');

        return [
            'title'       => 'Contact Us',
            'eyebrow'     => 'Get in Touch',
            'cover'       => self::image(config('data.rooms.0.feature_image')),
            'excerpt'     => 'Questions about your stay, a special event, or a reservation? Our team is happy to help.',
            'description' => array_values(array_filter([
                $addressLine !== '' ? $addressLine : null,
            ])),
            'meta'        => self::meta([
                'Phone'    => $cs['tel'] ?? '',
                'WhatsApp' => $cs['whatsapp'] ?? '',
                'Email'    => $cs['email'] ?? '',
            ]),
            'cta'         => null,
        ];
    }

    public static function text(mixed $value): string
    {
        return (is_string($value) || is_numeric($value)) ? trim((string) $value) : '';
    }

    public static function list(mixed $value): array
    {
        return collect(Arr::wrap($value))
            ->map(fn ($v) => self::text($v))
            ->filter()
            ->values()
            ->all();
    }

    public static function meta(array $rows): array
    {
        return collect($rows)
            ->map(fn ($value, $label) => ['label' => $label, 'value' => self::text($value)])
            ->filter(fn ($row) => $row['value'] !== '')
            ->values()
            ->all();
    }

    public static function image(mixed $path): ?string
    {
        $path = ltrim(self::text(is_array($path) ? Arr::first($path) : $path), '/');

        return ($path !== '' && is_file(public_path($path))) ? asset($path) : null;
    }

    public static function placeholder(): string
    {
        return asset(self::PLACEHOLDER);
    }

    private static function gallery(mixed $paths, string $title): array
    {
        $alt = trim($title . ' ' . config('app.name'));

        return collect(Arr::wrap($paths))
            ->map(fn ($p) => self::image($p))
            ->filter()
            ->map(fn ($url) => ['url' => $url, 'alt' => $alt])
            ->values()
            ->all();
    }

    private static function cta(string $text, mixed $link): ?array
    {
        $link = self::text($link);

        return $link !== '' ? ['text' => $text, 'link' => $link] : null;
    }

    private static function related(Collection $items, string $imageKey, string $route): array
    {
        return $items
            ->filter(fn ($i) => filled($i['title'] ?? '') && filled($i['slug'] ?? ''))
            ->take(4)
            ->map(fn ($i) => [
                'title' => self::text($i['title']),
                'img'   => self::image($i[$imageKey] ?? null) ?? self::placeholder(),
                'url'   => route($route, $i['slug']),
            ])
            ->values()
            ->all();
    }
}