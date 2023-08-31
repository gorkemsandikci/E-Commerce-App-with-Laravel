<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Panel Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['panelsetting', 'auth'], 'prefix' => 'panel', 'as' => 'panel.'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => 'slider'], function () {
        Route::get('', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::get('/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
        Route::put('/{id}/update', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');
        Route::post('/status-update', [SliderController::class, 'statusUpdate'])->name('slider.status');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::post('/status-update', [CategoryController::class, 'statusUpdate'])->name('category.status');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/destroy', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('/status-update', [ProductController::class, 'statusUpdate'])->name('product.status');
    });

    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');


    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
        Route::put('/{id}/update', [ContactController::class, 'update'])->name('contact.update');
        Route::delete('/destroy', [ContactController::class, 'destroy'])->name('contact.destroy');
        Route::post('/status-update', [ContactController::class, 'statusUpdate'])->name('contact.status');
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/create', [SettingController::class, 'create'])->name('setting.create');
        Route::post('/store', [SettingController::class, 'store'])->name('setting.store');
        Route::get('/{id}/edit', [SettingController::class, 'edit'])->name('setting.edit');
        Route::put('/{id}/update', [SettingController::class, 'update'])->name('setting.update');
        Route::delete('/destroy', [SettingController::class, 'destroy'])->name('setting.destroy');
    });
});
