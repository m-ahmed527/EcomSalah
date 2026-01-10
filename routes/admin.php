<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProductImportController;
use Illuminate\Support\Facades\Route;





Route::get('/dashboard', function () {
    $breadcrumbs = [
        'Dashboard' => '#',
    ];
    return view('screens.admin.index', get_defined_vars());
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
    Route::get('/get-data', 'getCategoriesData')->name('get.data');
    Route::post('/store', 'store')->name('store');
    Route::get('/destroy/{category}', 'destroy')->name('destroy');
    Route::post('/destroy/selected', 'destroySelected')->name('destroy.selected');
});

Route::name('attributes.')->prefix('attributes')->controller(AttributeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::get('/get-data', 'getAttributesData')->name('get.data');
    Route::get('/destroy/{attribute}', 'destroy')->name('destroy');
    Route::post('/destroy/selected', 'destroySelected')->name('destroy.selected');

});

Route::name('products.')->prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/get-data', 'getProductsData')->name('get.data');
    Route::get('/show/{product}', 'show')->name('show');
    Route::get('create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{product}', 'edit')->name('edit');
    Route::post('/update/{product}', 'update')->name('update');
    Route::get('/destroy/{product}', 'destroy')->name('destroy');
    Route::post('/destroy/selected', 'destroySelected')->name('destroy.selected');
    Route::get('/destroy/image/{image}', 'destroyImage')->name('image.destroy');
});
Route::name('imports.')->prefix('imports')->controller(ProductImportController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/get-data', 'getProductsData')->name('products.get.data');
    Route::post('/products', 'store')->name('products.store');
    Route::get('/products/sample', 'sampleCsv')->name('products.sample');
    Route::get('/products/status/{import}', 'status')->name('products.status');
    Route::get('/products/file/{import}', 'downloadProductFile')->name('products.file');
    Route::get('/products/errors/{import}', 'downloadErrors')->name('products.errors');
    Route::post('/products/destroy/selected', 'destroySelected')->name('products.destroy.selected');

});

Route::name('plans.')->prefix('plans')->controller(PlansController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/get-data', 'getPlansData')->name('get.data');
    Route::get('/show/{plan}', 'show')->name('show');
    Route::get('create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{plan}', 'edit')->name('edit');
    Route::post('/update/{plan}', 'update')->name('update');
    Route::get('/destroy/{plan}', 'destroy')->name('destroy');
    Route::post('/destroy/selected', 'destroySelected')->name('destroy.selected');
});