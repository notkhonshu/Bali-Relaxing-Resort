<?php

namespace App\Http\Controllers;

use App\Support\ListingPage;
use App\Support\Seo;

class HotelNewsController extends Controller
{
    public function index()
    {
        $items = ListingPage::hotelNews(config('data.hotel_news', []));

        return view('pages.landings.hotel-news', [
            'items' => $items,
            'seo'   => Seo::page('hotel-news'),
        ]);
    }
}