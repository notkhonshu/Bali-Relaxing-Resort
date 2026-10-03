<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.header')
</head>
<body>
    @php
        $bookUrl = trim((string) config('socials.book_url', ''));

        $accommodationMenu = collect(config('data.rooms', []))
            ->filter(fn ($room) => filled($room['title'] ?? '') && filled($room['slug'] ?? ''))
            ->map(fn ($room) => [
                'title'  => $room['title'],
                'slug'   => $room['slug'],
                'url'    => route('room.detail', $room['slug']),
                'active' => request()->routeIs('room.detail') && request()->route('slug') === $room['slug'],
            ])
            ->values()
            ->all();

        $facilityMenu = collect(config('data.facilityAndActivity', []))
            ->filter(fn ($item) => filled($item['title'] ?? '') && filled($item['slug'] ?? ''))
            ->map(fn ($item) => [
                'title'  => $item['title'],
                'slug'   => $item['slug'],
                'url'    => route('facility.detail', $item['slug']),
                'active' => request()->routeIs('facility.detail') && request()->route('slug') === $item['slug'],
            ])
            ->values()
            ->all();

        $navbarmenu = [
            [
                'title'  => 'Home',
                'slug'   => 'index',
                'url'    => route('index'),
                'active' => request()->routeIs('index'),
            ],
            [
                'title'    => 'Hotel News',
                'slug'     => 'hotel-news',
                'url'      => route('hotel-news.index'),
                'active'   => request()->routeIs('hotel-news.*', 'event-activity.*', 'whats-new.*'),
                'sub_menu' => [
                    [
                        'title'  => 'Event Activity',
                        'slug'   => 'event-activity',
                        'url'    => route('event-activity.index'),
                        'active' => request()->routeIs('event-activity.*'),
                    ],
                    [
                        'title'  => 'What’s New',
                        'slug'   => 'whats-new',
                        'url'    => route('whats-new.index'),
                        'active' => request()->routeIs('whats-new.*'),
                    ],
                ],
            ],
            [
                'title'    => 'Accommodation',
                'slug'     => 'accommodation',
                'url'      => route('room.index'),
                'active'   => request()->routeIs('room.*'),
                'sub_menu' => $accommodationMenu,
            ],
            [
                'title'    => 'Our Facility',
                'slug'     => 'facility',
                'url'      => route('facility.index'),
                'active'   => request()->routeIs('facility.*'),
                'sub_menu' => $facilityMenu,
            ],
            [
                'title'  => 'Promotion',
                'slug'   => 'promotion',
                'url'    => route('page', 'promotion'),
                'active' => request()->is('promotion'),
            ],
            [
                'title'  => 'Gallery',
                'slug'   => 'gallery',
                'url'    => route('page', 'gallery'),
                'active' => request()->is('gallery'),
            ],
            [
                'title'  => 'Contact Us',
                'slug'   => 'contact-us',
                'url'    => route('page', 'contact-us'),
                'active' => request()->is('contact-us'),
            ],
        ];

        $address = config('socials.address', []);
        $cs      = config('socials.customer_service', []);

        $socialMap = [
            'instagram' => ['title' => 'Instagram',   'icon' => 'ti-brand-instagram'],
            'facebook'  => ['title' => 'Facebook',    'icon' => 'ti-brand-facebook'],
            'tiktok'    => ['title' => 'TikTok',      'icon' => 'ti-brand-tiktok'],
            'youtube'   => ['title' => 'YouTube',     'icon' => 'ti-brand-youtube'],
            'twitter'   => ['title' => 'X (Twitter)', 'icon' => 'ti-brand-x'],
        ];

        $socials = collect($socialMap)
            ->map(fn ($social, $key) => $social + [
                'handle' => trim((string) config("socials.$key.name", '')),
                'url'    => trim((string) config("socials.$key.url", '')),
            ])
            ->filter(fn ($social) => filled($social['url']))
            ->values()
            ->all();

        $email    = trim((string) ($cs['email'] ?? ''));
        $emailUrl = filled($cs['url_email'] ?? '')
            ? $cs['url_email']
            : (filled($email) ? 'mailto:' . $email : '');

        $waNumber = trim((string) ($cs['whatsapp'] ?? ''));
        $waDigits = preg_replace('/\D/', '', $waNumber);
        $waUrl    = filled($cs['url_whatsapp'] ?? '')
            ? $cs['url_whatsapp']
            : (filled($waDigits) ? 'https://wa.me/' . $waDigits : '');

        $tel    = trim((string) ($cs['tel'] ?? ''));
        $telUrl = filled($cs['url_tel'] ?? '')
            ? $cs['url_tel']
            : (filled($tel) ? 'tel:' . preg_replace('/[^\d+]/', '', $tel) : '');

        $menuByTitle = collect($navbarmenu)->keyBy('title');

        $footer = [
            'address_lines' => collect([
                $address['name'] ?? '',
                $address['street'] ?? '',
                trim(($address['locality'] ?? '') . ' ' . ($address['postal_code'] ?? '')),
            ])->filter(fn ($line) => filled($line))->values()->all(),

            'map_url' => $address['url'] ?? '',

            'email'        => $email,
            'email_url'    => $emailUrl,
            'whatsapp'     => $waNumber,
            'whatsapp_url' => $waUrl,
            'tel'          => $tel,
            'tel_url'      => $telUrl,

            'book_url' => $bookUrl,

            'explore' => collect(['Home', 'Promotion', 'Gallery', 'Contact Us'])
                ->map(fn ($title) => $menuByTitle->get($title))
                ->filter()
                ->map(fn ($item) => ['title' => $item['title'], 'url' => $item['url']])
                ->values()
                ->all(),

            'rooms'          => $accommodationMenu,
            'rooms_url'      => route('room.index'),
            'facilities'     => $facilityMenu,
            'facilities_url' => route('facility.index'),

            'hotel_news' => $menuByTitle->get('Hotel News')['sub_menu'] ?? [],

            'socials' => $socials,
        ];
    @endphp

    @include('partials.navbar')
    @yield('content')
    @include('partials.footer', ['footer' => $footer])
</body>
</html>