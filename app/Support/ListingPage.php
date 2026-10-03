<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ListingPage
{
    public static function rooms(array $rooms): array
    {
        return collect($rooms)
            ->filter(fn ($r) => filled($r['title'] ?? '') && filled($r['slug'] ?? ''))
            ->map(fn ($r) => self::card(
                item:      $r,
                eyebrow:   'Accommodation',
                image:     $r['feature_image'] ?? null,
                meta:      ['Size' => $r['size'] ?? '', 'Rooms' => $r['total_room'] ?? ''],
                amenities: array_slice(DetailPage::list($r['amenities'] ?? []), 0, 5),
                route:     'room.detail',
            ))
            ->values()
            ->all();
    }

    public static function facilities(array $items): array
    {
        return collect($items)
            ->filter(fn ($f) => filled($f['title'] ?? '') && filled($f['slug'] ?? ''))
            ->map(fn ($f) => self::card(
                item:      $f,
                eyebrow:   ucfirst(DetailPage::text(Arr::first(Arr::wrap($f['categories'] ?? '')))) ?: 'Facility',
                image:     $f['feature_images'] ?? null,
                meta:      ['Open' => $f['open_time'] ?? ''],
                amenities: [],
                route:     'facility.detail',
            ))
            ->values()
            ->all();
    }
    
    public static function promotions(array $items): array
    {
        return collect($items)
            ->filter(fn ($p) => filled($p['title'] ?? ''))
            ->map(function ($p) {
                $title = DetailPage::text($p['title']);

                return [
                    'title'       => $title,
                    'description' => DetailPage::text($p['excerpt'] ?? ''),
                    'img'         => [
                        'url' => DetailPage::image($p['image'] ?? null),
                        'alt' => trim($title . ' ' . config('app.name')),
                    ],
                    'url'         => ['text' => 'Inquire Now', 'link' => route('page', 'contact-us')],
                ];
            })
            ->filter(fn ($p) => filled($p['img']['url']))
            ->values()
            ->all();
    }

    public static function hotelNews(array $items): array
    {
        return collect($items)
            ->filter(fn ($n) => filled($n['title'] ?? '') && filled($n['slug'] ?? ''))
            ->map(fn ($n) => self::card(
                item:      $n,
                eyebrow:   'Hotel News',
                image:     $n['images'] ?? null,
                meta:      [],
                amenities: [],
                route:     'page',
            ))
            ->values()
            ->all();
    }

    public static function gallery(string $folder): array
    {
        $dir = public_path($folder);

        if (! is_dir($dir)) {
            return [];
        }

        $alt = trim('Gallery ' . config('app.name'));

        return collect(File::files($dir))
            ->filter(fn ($f) => in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'], true))
            ->sortBy(fn ($f) => $f->getFilename(), SORT_NATURAL)
            ->values()
            ->map(fn ($f, $i) => [
                'url' => asset($folder . '/' . rawurlencode($f->getFilename())),
                'alt' => $alt . ' ' . ($i + 1),
            ])
            ->all();
    }

    public static function eventActivities(array $items): array
    {
        return self::articles($items, 'event-activity.detail');
    }

    public static function whatsNew(array $items): array
    {
        return self::articles($items, 'whats-new.detail');
    }

    private static function articles(array $items, string $route): array
    {
        return collect($items)
            ->filter(fn ($a) => filled($a['title'] ?? '') && filled($a['slug'] ?? ''))
            ->map(function ($a) use ($route) {
                $title = DetailPage::text($a['title']);
                $alt   = trim($title . ' ' . config('app.name'));

                return [
                    'title'       => $title,
                    'description' => DetailPage::text($a['excerpt'] ?? ''),
                    'images'      => collect(Arr::wrap($a['images'] ?? []))
                        ->map(fn ($p) => DetailPage::image($p))
                        ->filter()
                        ->map(fn ($url) => ['url' => $url, 'alt' => $alt])
                        ->values()
                        ->all(),
                    'url'         => [
                        'text' => 'View Details',
                        'link' => route($route, $a['slug']),
                    ],
                ];
            })
            ->filter(fn ($a) => $a['images'] !== [])
            ->values()
            ->all();
    }

    private static function card(
        array $item,
        string $eyebrow,
        mixed $image,
        array $meta,
        array $amenities,
        string $route,
    ): array {
        $title = DetailPage::text($item['title']);

        return [
            'eyebrow'     => $eyebrow,
            'title'       => $title,
            'description' => self::summary($item),
            'img'         => [
                'url' => DetailPage::image($image) ?? DetailPage::placeholder(),
                'alt' => trim($title . ' ' . config('app.name')),
            ],
            'meta'        => DetailPage::meta($meta),
            'amenities'   => $amenities,
            'url'         => ['text' => 'View Details', 'link' => route($route, $item['slug'])],
        ];
    }

    private static function summary(array $item): string
    {
        $text = DetailPage::text($item['excerpt'] ?? '');

        if ($text === '') {
            $text = DetailPage::text(Arr::first(Arr::wrap($item['description'] ?? [])));
        }

        return Str::limit($text, 240);
    }
}