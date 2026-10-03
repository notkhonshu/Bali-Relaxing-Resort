@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'         => 'gallery_hero',
            'tag_title'  => 'h1',
            'title'      => 'Gallery',
            'tagline'    => 'Bali Relaxing Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => ($cover = collect($items)->pluck('url')->first())
                    ? ['url' => $cover, 'alt' => 'Gallery']
                    : null,
            ],
        ],
    ])

    @include('components.sections.type12', [
        'section_data' => [
            'id'     => 'gallery_grid',
            'images' => $items,
        ],
    ])
@endsection