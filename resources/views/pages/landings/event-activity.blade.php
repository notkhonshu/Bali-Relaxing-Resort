@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'         => 'event_activity_hero',
            'tag_title'  => 'h1',
            'title'      => 'Event Activity',
            'tagline'    => 'Bali Relaxing Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => ($cover = collect($items)->pluck('images.0.url')->filter()->first())
                    ? ['url' => $cover, 'alt' => 'Event Activity']
                    : null,
            ],
        ],
    ])

    @include('components.sections.type10', [
        'section_data' => [
            'id'        => 'event_activity_list',
            'tag_title' => 'h2',
            'items'     => $items,
        ],
    ])
@endsection