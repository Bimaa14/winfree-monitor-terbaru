<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicMapController;

Route::view('/', 'public.home')->name('public.home');              // landing kayak wifi.id
Route::get('/map', [PublicMapController::class, 'index'])->name('public.map'); // peta lu
