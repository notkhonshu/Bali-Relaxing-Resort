@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'         => 'whats_new_detail_hero',
            'tag_title'  => 'h1',
            'title'      => 'What’s New',
            'tagline'    => 'Bali Relaxing Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => $detail['cover']
                    ? ['url' => $detail['cover'], 'alt' => $detail['title']]
                    : null,
            ],
        ],
    ])

    @include('components.sections.type11', [
        'section_data' => [
            'id'          => 'whats_new_article',
            'tag_title'   => 'h2',
            'breadcrumbs' => $detail['breadcrumbs'],
            'eyebrow'     => $detail['eyebrow'],
            'title'       => $detail['title'],
            'excerpt'     => $detail['excerpt'],
            'image'       => $detail['cover']
                ? ['url' => $detail['cover'], 'alt' => $detail['title']]
                : null,
            'description' => $detail['description'],
            'cta'         => $detail['cta'],
            'prev'        => $detail['prev'],
            'next'        => $detail['next'],
        ],
    ])

    @include('components.sections.type9', [
        'section_data' => [
            'id'        => 'whats_new_related',
            'tag_title' => 'h2',
            'title'     => $detail['related_title'],
            'more'      => $detail['related_more'],
            'items'     => $detail['related'],
        ],
    ])
@endsection