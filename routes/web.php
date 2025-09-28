<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicMapController; // Pindahkan ini ke atas

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Hapus route bawaan Laravel yang ini:
// Route::get('/', function () {
//     return view('welcome');
// });

// Sisakan route baru kita yang ini:
Route::get('/', [PublicMapController::class, 'index']);