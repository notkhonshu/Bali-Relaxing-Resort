<?php

namespace App\Http\Controllers;

use App\Support\DetailPage;
use App\Support\ListingPage;
use App\Support\Seo;

class EventActivityController extends Controller
{
    public function index()
    {
        $items = ListingPage::eventActivities(config('data.event_activity', []));

        return view('pages.landings.event-activity', [
            'items' => $items,
            'seo'   => Seo::page('event-activity'),
        ]);
    }

    public function detail(string $slug)
    {
        $events = collect(config('data.event_activity', []));
        $event  = $events->firstWhere('slug', $slug);

        abort_unless($event, 404);

        $detail = DetailPage::eventActivity($event, $events);

        return view('pages.details.detail', [
            'detail' => $detail,
            'seo'    => Seo::detail($detail),
        ]);
    }
}