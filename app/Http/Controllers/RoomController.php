<?php

namespace App\Http\Controllers;

use App\Support\DetailPage;
use App\Support\ListingPage;
use App\Support\Seo;

class RoomController extends Controller
{
    public function index()
    {
        $items = ListingPage::rooms(config('data.rooms', []));

        return view('pages.landings.accommodation', [
            'items' => $items,
            'seo'   => Seo::page('accommodation'),
        ]);
    }

    public function detail(string $slug)
    {
        $rooms = collect(config('data.rooms', []));
        $room  = $rooms->firstWhere('slug', $slug);

        abort_unless($room, 404);

        $detail = DetailPage::room($room, $rooms);

        return view('pages.details.detail', [
            'detail' => $detail,
            'seo'    => Seo::detail($detail),
        ]);
    }
}