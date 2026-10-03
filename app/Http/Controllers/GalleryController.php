<?php

namespace App\Http\Controllers;

use App\Support\ListingPage;
use App\Support\Seo;

class GalleryController extends Controller
{
    public function index()
    {
        $items = ListingPage::gallery('assets/img/static/gallery');

        return view('pages.landings.gallery', [
            'items' => $items,
            'seo'   => Seo::page('gallery'),
        ]);
    }
}