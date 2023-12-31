<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PageController;
use App\Jobs\PulseJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

    Route::get('/urunler/{slug?}', [PageController::class, 'urunler'])->name('urunler');
    Route::get('/indirimdekiler', [PageController::class, 'indirimdekiurunler'])->name('indirimdekiurunler');

    Route::get('/urun/{slug}', [PageController::class, 'urundetay'])->name('urundetay');

    Route::get('/hakkimizda', [PageController::class, 'hakkimizda'])->name('hakkimizda');

    Route::get('/iletisim', [PageController::class, 'iletisim'])->name('iletisim');
    Route::post('/iletisim/kaydet', [AjaxController::class, 'iletisimkaydet'])->name('iletisim.kaydet');

    Route::group(['prefix' => 'sepet'], function () {
        Route::post('/ekle', [CartController::class, 'add'])->name('sepet.ekle');
        Route::post('/new-qty', [CartController::class, 'newQty'])->name('sepet.new-qty');
        Route::post('/cikar', [CartController::class, 'remove'])->name('sepet.remove');
        Route::get('/', [CartController::class, 'index'])->name('sepet');
        Route::post('/couponcheck', [CartController::class, 'couponcheck'])->name('coupon.check');
        Route::group(['prefix' => 'form'], function () {
            Route::get('/', [CartController::class, 'cartForm'])->name('sepet.form');
        });
        Route::post('/save', [CartController::class, 'cartSave'])->name('sepet.cart-save');
    });

    Auth::routes();

    Route::get('/fakelogins', function () {
        $users = User::all();
        $base_url = config('app.url');

        foreach ($users as $user) {
            Http::get("{$base_url}/fakelogin/{$user->id}");
        }

        return 'Request complete!';
    });

    Route::get('/fakelogin/{user}', function (User $user) {
        $base_url = config('app.url');
        auth()->login($user);

        Http::get("{$base_url}/dashboard");

        auth()->logout();
    });

    Route::middleware('auth', 'verified')->get('/job', function() {
        PulseJob::dispatch();
    });

    Route::get('/cikis', [AjaxController::class, 'logout'])->name('cikis');
});
