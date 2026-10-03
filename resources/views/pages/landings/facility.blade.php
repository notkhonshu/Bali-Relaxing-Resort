@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'         => 'facility_hero',
            'tag_title'  => 'h1',
            'title'      => 'Our Facility',
            'tagline'    => 'Bali Relaxing Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => ($cover = collect($items)->pluck('img.url')->filter()->first())
                    ? ['url' => $cover, 'alt' => 'Our Facility']
                    : null,
            ],
        ],
    ])

    @include('components.sections.type4', [
        'section_data' => [
            'id'        => 'facility_list',
            'tag_title' => 'h2',
            'items'     => $items,
        ],
    ])
@endsection