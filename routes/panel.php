<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
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
});
