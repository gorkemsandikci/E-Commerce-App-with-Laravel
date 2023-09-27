<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Auth;
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

    Route::group(['prefix' => 'sepet'], function () {
        Route::post('/ekle', [CartController::class, 'add'])->name('sepet.ekle');
        Route::post('/new-qty', [CartController::class, 'newQty'])->name('sepet.new-qty');
        Route::post('/cikar', [CartController::class, 'remove'])->name('sepet.cikar');
        Route::get('/', [CartController::class, 'index'])->name('sepet');
        Route::post('/couponcheck', [CartController::class, 'couponcheck'])->name('coupon.check');
        Route::group(['prefix' => 'form'], function () {
            Route::get('/', [CartController::class, 'sepetForm'])->name('sepet.form');
        });
        Route::post('/save', [CartController::class, 'cartSave'])->name('sepet.cart-save');
    });

    Auth::routes();

    Route::get('/cikis', [AjaxController::class, 'logout'])->name('cikis');

});
