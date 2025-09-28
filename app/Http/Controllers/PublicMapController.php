<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class PublicMapController extends Controller
{
    public function index()
    {
        // Ambil semua data site dari database
        $sites = Site::all();

        // Kirim data ke file tampilan 'public-map'
        return view('public-map', ['sites' => $sites]);
    }
}
