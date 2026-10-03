<?php

namespace App\Http\Controllers;

use App\Support\DetailPage;
use App\Support\ListingPage;
use App\Support\Seo;

class FacilityController extends Controller
{
    public function index()
    {
        $items = ListingPage::facilities(config('data.facilityAndActivity', []));

        return view('pages.landings.facility', [
            'items' => $items,
            'seo'   => Seo::page('facility'),
        ]);
    }

    public function detail(string $slug)
    {
        $facilities = collect(config('data.facilityAndActivity', []));
        $facility   = $facilities->firstWhere('slug', $slug);

        abort_unless($facility, 404);

        $detail = DetailPage::facility($facility, $facilities);

        return view('pages.details.detail', [
            'detail' => $detail,
            'seo'    => Seo::detail($detail),
        ]);
    }
}