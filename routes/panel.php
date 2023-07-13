<?php

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

    Route::get('/', [DashboardController::class, 'index'])->name('index');

});
