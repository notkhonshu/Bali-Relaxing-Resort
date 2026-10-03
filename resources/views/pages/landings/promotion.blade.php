@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'        => 'promotion_hero',
            'tag_title' => 'h1',
            'title'     => 'Promotion',
            'tagline'   => config('app.name') . ' Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => [
                    'url' => asset('assets/img/static/landings/1.jpg'),
                    'alt' => 'Promotion ' . config('app.name'),
                ],
            ],
        ],
    ])

    @php
        $promotions = collect(config('data.promotions', []))
            ->map(fn ($item) => [
                'title'       => $item['title'] ?? '',
                'description' => $item['excerpt'] ?? '',
                'images'      => collect($item['images'] ?? [])
                    ->map(fn ($image) => [
                        'url' => asset($image),
                        'alt' => ($item['title'] ?? '') . ' flyer ' . config('app.name'),
                    ])
                    ->all(),
            ])
            ->values()
            ->all();
    @endphp

    @include('components.sections.type10', [
        'section_data' => [
            'id'        => 'promotion_section',
            'tag_title' => 'h2',
            'cta'       => [
                'text' => 'Inquire now',
                'link' => config('social.customer_service.url_email'),
            ],
            'items'     => $promotions,
        ],
    ])
@endsection