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
                    'url' => asset('assets/img/about/1.jpg'), 
                    'alt' => config('app.name')
                ],
                [
                    'url' => asset('assets/img/about/2.jpg'), 
                    'alt' => config('app.name')
                ],
                [
                    'url' => asset('assets/img/about/3.jpg'), 
                    'alt' => config('app.name')
                ],
            ],
        ],
    ])

@endsection