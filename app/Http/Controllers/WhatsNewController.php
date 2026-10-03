<?php

namespace App\Http\Controllers;

use App\Support\DetailPage;
use App\Support\ListingPage;
use App\Support\Seo;

class WhatsNewController extends Controller
{
    public function index()
    {
        $items = ListingPage::whatsNew(config('data.news', []));

        return view('pages.landings.whats-new', [
            'items' => $items,
            'seo'   => Seo::page('whats-new'),
        ]);
    }

    public function detail(string $slug)
    {
        $news = collect(config('data.news', []));
        $item = $news->firstWhere('slug', $slug);

        abort_unless($item, 404);

        $detail = DetailPage::whatsNew($item, $news);

        return view('pages.details.whats-new', [
            'detail' => $detail,
            'seo'    => Seo::detail($detail, 'article'),
        ]);
    }
}