<?php

namespace App\Http\Controllers;

use App\Models\Site;

class PublicMapController extends Controller
{
    public function index()
    {
        $sites = Site::all();

        return view('public.public-map', compact('sites'));
    }
}
