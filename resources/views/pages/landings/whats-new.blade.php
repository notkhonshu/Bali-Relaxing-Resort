@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'         => 'whats_new_hero',
            'tag_title'  => 'h1',
            'title'      => 'What’s New',
            'tagline'    => 'Bali Relaxing Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => asset('assets/img/static/whats-new/5.jpg'),
            ],
        ],
    ])

    @include('components.sections.type10', [
        'section_data' => [
            'id'        => 'whats_new_list',
            'tag_title' => 'h2',
            'items'     => $items,
        ],
    ])
@endsection