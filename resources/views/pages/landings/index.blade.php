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

@endsection