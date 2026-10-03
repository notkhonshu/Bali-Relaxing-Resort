<?php

namespace App\Http\Controllers;

use App\Support\Seo;

class LandingController extends Controller
{
    public function index()
    {
        return view('pages.landings.index', [
            'seo' => Seo::page('home', ['schema' => Seo::hotelSchema()]),
        ]);
    }

    public function page(string $slug)
    {
        $view = 'pages.landings.' . $slug;

        abort_unless(view()->exists($view), 404);

        return view($view, ['seo' => Seo::page($slug)]);
    }
}