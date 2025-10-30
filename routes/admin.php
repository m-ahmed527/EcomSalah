<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;





Route::get('/dashboard', function () {
    return view('screens.admin.index');
})->name('index');

Route::name('settings.')->controller(SettingController::class)->group(function () {
    Route::get('/settings', 'index')->name('index');
    Route::post('/settings/update', 'update')->name('update');
});
Route::name('profile.')->prefix('profile')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/update', 'update')->name('update');
});

Route::name('categories.')->prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});
