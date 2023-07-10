<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'sitesetting'], function () {

    Route::get('/', [HomePageController::class, 'index'])->name('anasayfa');

    Route::get('/urunler', [PageController::class, 'urunler'])->name('urunler');
    Route::get('/kadin/{slug?}', [PageController::class, 'urunler'])->name('kadinurunler');
    Route::get('/erkek/{slug?}', [PageController::class, 'urunler'])->name('erkekurunler');
    Route::get('/cocuk/{slug?}', [PageController::class, 'urunler'])->name('cocukurunler');
    Route::get('/indirimdekiler', [PageController::class, 'indirimdekiurunler'])->name('indirimdekiurunler');

    Route::get('/urun/{slug}', [PageController::class, 'urundetay'])->name('urundetay');

    Route::get('/hakkimizda', [PageController::class, 'hakkimizda'])->name('hakkimizda');

    Route::get('/iletisim', [PageController::class, 'iletisim'])->name('iletisim');
    Route::post('/iletisim/kaydet', [AjaxController::class, 'iletisimkaydet'])->name('iletisim.kaydet');

    Route::get('/sepet', [PageController::class, 'sepet'])->name('sepet');

});
