@extends('layouts.main')

@php
    $hasOverview = filled($detail['excerpt'])
        || count($detail['description'])
        || count($detail['meta'])
        || count($detail['amenities'])
        || !empty($detail['cta']);
@endphp

@section('content')
    @if (filled($detail['title']))
        @include('components.sections.type1', [
            'section_data' => [
                'id'         => 'detail_hero',
                'tag_title'  => 'h1',
                'title'      => $detail['title'],
                'tagline'    => $detail['eyebrow'],
                'background' => [
                    'type'  => 'image',
                    'image' => $detail['cover']
                        ? ['url' => $detail['cover'], 'alt' => $detail['title']]
                        : null,
                ],
            ],
        ])
    @endif

    @if ($hasOverview)
        @include('components.sections.type8', [
            'section_data' => [
                'id'          => 'detail_overview',
                'tag_title'   => 'h2',
                'eyebrow'     => $detail['eyebrow'],
                'title'       => $detail['title'],
                'excerpt'     => $detail['excerpt'],
                'description' => $detail['description'],
                'meta'        => $detail['meta'],
                'amenities'   => $detail['amenities'],
                'cta'         => $detail['cta'],
            ],
        ])
    @endif

    @if (count($detail['gallery']))
        @include('components.sections.type7', [
            'section_data' => [
                'id'             => 'detail_gallery',
                'tag_title'      => 'h2',
                'title'          => 'Gallery',
                'autoplay_delay' => 3500,
                'images'         => $detail['gallery'],
            ],
        ])
    @endif

    @include('components.sections.type9', [
        'section_data' => [
            'id'        => 'detail_related',
            'tag_title' => 'h2',
            'title'     => $detail['related_title'],
            'more'      => $detail['related_more'],
            'items'     => $detail['related'],
        ],
    ])
@endsection