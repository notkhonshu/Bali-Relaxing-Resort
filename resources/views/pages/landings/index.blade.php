@extends('layouts.main')

@section('content')
    @include('components.sections.type1',[
        'section_data' => [
            'id' => 'hero_section',
            'tag_title' => 'h1',
            'title' => config('app.name'),
            'tagline' => 'resort & spa',
            'background' =>[
                'type' => 'video',
                'video' => [
                    'url' => asset('assets/vid/brr4.mp4'),
                    'alt' => 'Video '. config('app.name'),
                ],
            ],
        ],
    ])

    @include('components.sections.type2', [
        'section_data' => [
            'id'          => 'about_section',
            'tag_title'   => 'h2',
            'eyebrow'     => 'Welcome to',
            'title'       => config('app.name'). ' Resort & Spa',
            'description' => 'Bali Relaxing Resort & Spa set at the most popular point of sea sport activities, set at lush tropical garden and white sandy beach. This hotel is ideally located in Tanjung Benoa Bay and offers a spectacular beach view. Bali Relaxing Resort & Spa has a beautiful beach front. The Resort is close to the main shopping area in Tanjung Benoa or the neighborhood "Nusa Dua" only 5 minutes drive, takes 25 minutes drive to Ngurah Rai Airport. Bali Relaxing Resort & Spa designed with modern minimalist and furnished with modern amenities. The Resort is a perfect hotel for relaxing with families, friends even business purposes without any hassle to follow or attend.',
            'images' => [
                [
                    'url' => asset('assets/img/static/landings/1.jpg'), 
                    'alt' => config('app.name')
                ],
                [
                    'url' => asset('assets/img/static/landings/3.jpg'), 
                    'alt' => config('app.name')
                ],
                [
                    'url' => asset('assets/img/static/landings/2.jpg'), 
                    'alt' => config('app.name')
                ],
            ],
        ],
    ])
    @php
        $rooms = [];
    
        foreach (config('data.rooms', []) as $room) {
            $rooms[] = [
                'img' => [
                    'url' => asset(!empty($room['feature_image']) ? $room['feature_image'] : 'assets/img/static/lazy/placeholder.png'),
                    'alt' => ($room['title'] ?? '') . ' ' . config('app.name'),
                ],
                'title'       => $room['title'] ?? '',
                'sized'       => $room['size'] ?? '',
                'total'       => $room['total_room'] ?? '',
                'description' => $room['excerpt'] ?? '',
                'url'         => [
                    'text' => 'Discover More',
                    'link' => !empty($room['slug']) ? route('room.detail', $room['slug']) : null,
                ],
            ];
        }
    
        $itemLink = fn ($item) => !empty($item['url'])
            ? $item['url']
            : (!empty($item['slug']) ? route('facility.detail', $item['slug']) : null);
    @endphp

    @include('components.sections.type3', [
        'section_data' => [
            'id'        => 'rooms_section',
            'tag_title' => 'h2',
            'eyebrow'   => 'Bali Relaxing',
            'title'     => 'Accommodation',
            'rooms'     => $rooms,
        ],
    ])

    @php
        $activities = collect(config('data.facilityAndActivity', []))
            ->where('categories', 'activities')
            ->map(fn ($item) => [
                'title'       => $item['title'] ?? '',
                'description' => $item['excerpt'] ?? '',
                'img'         => [
                    'url' => asset(!empty($item['feature_images']) ? $item['feature_images'] : 'assets/img/static/lazy/placeholder.png'),
                    'alt' => ($item['title'] ?? '') . ' ' . config('app.name'),
                ],
                'url'         => [
                    'text' => !empty($item['url']) ? 'Book Now' : 'View More',
                    'link' => $itemLink($item),
                ],
            ])
            ->values()
            ->all();
    @endphp

    @include('components.sections.type4', [
        'section_data' => [
            'id'        => 'activities_section',
            'tag_title' => 'h2',
            'background'=> 'bg-background-seconddary',
            'items'     => $activities,
        ],
    ])

    @php
        $facilities = collect(config('data.facilityAndActivity', []))
            ->where('categories', 'facilities')
            ->map(fn ($item) => [
                'title'   => $item['title'] ?? '',
                'excerpt' => $item['excerpt'] ?? '',
                'img'     => [
                    'url' => asset(!empty($item['feature_images']) ? $item['feature_images'] : 'assets/img/static/lazy/placeholder.png'),
                    'alt' => ($item['title'] ?? '') . ' ' . config('app.name'),
                ],
                'url'     => [
                    'text' => 'View More',
                    'link' => $itemLink($item),
                ],
            ])
            ->values()
            ->all();
    @endphp

    @include('components.sections.type5', [
        'section_data' => [
            'id'        => 'facilities_section',
            'tag_title' => 'h2',
            'title'     => 'Our Facilities',
            'items'     => $facilities,
        ],
    ])
    @include('components.sections.type6', [
        'section_data' => [
            'id'    => 'map_section',
            'title' => 'Bali Relaxing Resort Location',
            'embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.0878411608146!2d115.22143317592986!3d-8.777806189679149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2430f64c91971%3A0x983c89f4280ffa82!2sBali%20Relaxing%20Resort%20%26%20Spa!5e0!3m2!1sid!2sid!4v1790584952603!5m2!1sid!2sid',
        ],
    ])
    @php
        $galleryPath = 'assets/img/static/landings';

        $gallery = collect(\Illuminate\Support\Facades\File::files(public_path($galleryPath)))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']))
            ->sortBy(fn ($file) => $file->getFilename(), SORT_NATURAL)
            ->map(fn ($file) => [
                'url' => asset($galleryPath . '/' . $file->getFilename()),
                'alt' => config('app.name') . ' Gallery',
            ])
            ->values()
            ->all();
    @endphp

    @include('components.sections.type7', [
        'section_data' => [
            'id'        => 'gallery_section',
            'tag_title' => 'h2',
            'title'     => 'Services & Facilities',
            'images'    => $gallery,
        ],
    ])

@endsection