<?php

return [
    'title'       => config('app.name') . ' – Resort & Spa in [Lokasi], Bali',
    'description' => 'Stay at ' . config('app.name') . ' in [Lokasi], Bali. Rooms, spa, dining, and activities. Book direct for the best rate.',
    'keyword'     => 'hotel [lokasi], resort bali, spa bali',

    'og-title'        => config('app.name'),
    'og-description'  => 'Stay at ' . config('app.name') . ' in [Lokasi], Bali. Book direct for the best rate.',
    'og-site-name'    => config('app.site_name') ?: config('app.name'),
    'og-type'         => 'website',
    'og-latitude'     => '',
    'og-longitude'    => '', 
    'og-locality'     => '',
    'og-region'       => 'Bali',
    'og-postal-code'  => '',
    'og-country-name' => 'Indonesia',

    'google_site_verification' => 'J_AppAA0Oz_nGZykqD4iwfHSXTcPY-xTELcIX1JoJck',

    'pages' => [
        'home' => [
            'title'       => ':site – Resort & Spa in [Lokasi], Bali',
            'description' => 'Stay at :site in [Lokasi], Bali. Private rooms, spa, dining, and activities. Book direct for the best rate.',
            'keyword'     => 'hotel [lokasi], resort bali, spa bali',
        ],
        'accommodation' => [
            'title'       => 'Rooms & Suites',
            'description' => 'Explore our rooms and suites at :site. Comfortable accommodation with modern amenities in [Lokasi], Bali.',
        ],
        'facility' => [
            'title'       => 'Facilities & Activities',
            'description' => 'Discover pool, spa, restaurant, and activities at :site for a relaxing Bali holiday.',
        ],
        'event-activity' => [
            'title'       => 'Events & Activities',
            'description' => 'Join events and activities at :site, from wellness sessions to cultural experiences.',
        ],
        'whats-new' => [
            'title'       => 'What’s New',
            'description' => 'Latest updates, offers, and happenings at :site.',
        ],
        'hotel-news' => [
            'title'       => 'Hotel News',
            'description' => 'News and announcements from :site in [Lokasi], Bali.',
        ],
        'gallery' => [
            'title'       => 'Photo Gallery',
            'description' => 'Browse photos of rooms, facilities, and surroundings at :site.',
        ],
        'contact-us' => [
            'title'       => 'Contact Us',
            'description' => 'Contact :site for reservations, events, and enquiries. Call, WhatsApp, or send us a message.',
        ],
    ],
];