@extends('layouts.main')

@section('content')
    @include('components.sections.type1', [
        'section_data' => [
            'id'         => 'contact_hero',
            'tag_title'  => 'h1',
            'title'      => $detail['title'],
            'tagline'    => 'Bali Relaxing Resort & Spa',
            'background' => [
                'type'  => 'image',
                'image' => $detail['cover']
                    ? ['url' => $detail['cover'], 'alt' => $detail['title']]
                    : null,
            ],
        ],
    ])

    @include('components.sections.type8', [
        'section_data' => [
            'id'          => 'contact_info',
            'tag_title'   => 'h2',
            'eyebrow'     => $detail['eyebrow'],
            'title'       => $detail['title'],
            'excerpt'     => $detail['excerpt'],
            'description' => $detail['description'],
            'meta'        => $detail['meta'],
            'amenities'   => [],
            'cta'         => $detail['cta'],
            'form'        => [
                'id'        => 'contact_form',
                'tag_title' => 'h3',
                'title'     => 'Send a Message',
                'action'    => route('contact-us.send'),
            ],
        ],
    ])

    @include('components.sections.type6', [
        'section_data' => [
            'id'    => 'map_section',
            'title' => 'Bali Relaxing Resort Location',
            'embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.0878411608146!2d115.22143317592986!3d-8.777806189679149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2430f64c91971%3A0x983c89f4280ffa82!2sBali%20Relaxing%20Resort%20%26%20Spa!5e0!3m2!1sid!2sid!4v1790584952603!5m2!1sid!2sid',
        ],
    ])
@endsection