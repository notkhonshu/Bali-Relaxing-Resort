<?php

namespace App\Support;

use Illuminate\Support\Str;

class Seo
{
    public static function siteName(): string
    {
        return config('metadata.og-site-name') ?: (string) config('app.name');
    }

    public static function make(?string $title = null, ?string $description = null, ?string $image = null, array $extra = []): array
    {
        $site  = self::siteName();
        $title = DetailPage::text($title);

        $fullTitle = $title === ''
            ? config('metadata.title')
            : (Str::contains($title, $site) ? $title : $title . ' | ' . $site);

        $description = Str::limit(trim(strip_tags(DetailPage::text($description))), 160);
        $description = $description !== '' ? $description : config('metadata.description');

        return array_merge([
            'title'          => $fullTitle,
            'description'    => $description,
            'og-title'       => $fullTitle,
            'og-description' => $description,
            'og-site-name'   => $site,
            'og-image'       => $image ?: asset('assets/img/metadata/featured_image/image.png'),
            'og-type'        => config('metadata.og-type', 'website'),
            'robots'         => 'index, follow',
        ], $extra);
    }

    public static function page(string $key, array $extra = []): array
    {
        $p    = config("metadata.pages.$key", []);
        $site = self::siteName();
        $fill = fn ($v) => is_string($v) ? str_replace(':site', $site, $v) : $v;

        return self::make(
            $fill($p['title'] ?? Str::headline($key)),
            $fill($p['description'] ?? null),
            null,
            array_merge(array_filter(['keyword' => $p['keyword'] ?? null]), $extra)
        );
    }

    /** Halaman detail: dari array hasil DetailPage::* */
    public static function detail(array $detail, string $type = 'website'): array
    {
        $description = ($detail['excerpt'] ?? '') ?: ($detail['description'][0] ?? '');

        return self::make(
            $detail['title'] ?? '',
            $description,
            $detail['cover'] ?? null,
            ['og-type' => $type]
        );
    }

    /** JSON-LD Hotel untuk homepage */
    public static function hotelSchema(): array
    {
        $a  = config('socials.address', []);
        $cs = config('socials.customer_service', []);

        $lat = config('metadata.og-latitude');
        $lng = config('metadata.og-longitude');

        return array_filter([
            '@context'  => 'https://schema.org',
            '@type'     => 'Hotel',
            'name'      => self::siteName(),
            'url'       => url('/'),
            'image'     => asset('assets/img/metadata/featured_image/image.png'),
            'telephone' => $cs['tel'] ?? null,
            'email'     => $cs['email'] ?? null,
            'address'   => array_filter([
                '@type'           => 'PostalAddress',
                'streetAddress'   => $a['street'] ?? null,
                'addressLocality' => $a['locality'] ?? config('metadata.og-locality'),
                'addressRegion'   => config('metadata.og-region'),
                'postalCode'      => $a['postal_code'] ?? config('metadata.og-postal-code'),
                'addressCountry'  => 'ID',
            ]),
            'geo' => ($lat && $lng) ? [
                '@type'     => 'GeoCoordinates',
                'latitude'  => (float) $lat,
                'longitude' => (float) $lng,
            ] : null,
        ]);
    }
}