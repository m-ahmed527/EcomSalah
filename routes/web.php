<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Web\AboutUsController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::take(3)->get();
    return view('screens.web.index', get_defined_vars());
})->name('web.index');


Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerPost')->name('register');
    Route::post('/logout', 'logout')->name('logout')->withoutMiddleware('guest')->middleware('auth');
    Route::get('/forget-password', 'forgetPassword')->name('forget-password');

});

Route::prefix('web')->name('web.')->group(function () {
    Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->controller(DashboardController::class)->group(function () {
        Route::get('/profile/index', 'profile')->name('profile.index');
        Route::post('/profile/update', 'profileUpdate')->name('profile.update');
        Route::get('/orders/index', 'order')->name('orders.index');
        Route::post('/update-profile-image', 'updateProfileImage')->name('update.profile.image');
    });
    Route::prefix('about')->name('about.')->controller(AboutUsController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
    });
    Route::prefix('blog')->name('blog.')->controller(BlogController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
    });
    Route::prefix('contact')->name('contact.')->controller(ContactController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
    });
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::get('/index', 'index')->name('index')->middleware('cart');
        Route::post('/add', 'addOrUpdate')->name('add');
        Route::post('/update', 'updateQuantity')->name('update');
        Route::post('/remove', 'removeCart')->name('remove')->middleware('cart');
    });
    Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
    });
    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/show/{product}', 'show')->name('show');
        Route::post('/get-variant', 'getVariant')->name('get.variant');
        Route::get('/details/{product}', 'details')->name('details');
    });

});

Route::get('/clear-cache/{key}', function ($key) {
    if ($key !== 'password')
        abort(403);
    // dd(session()->all());
    session()->flush();
    Artisan::call('optimize:clear');
    // Artisan::call('queue:restart');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    // exec('rm ' . storage_path('logs/*.log'));
    return view('clear-cache');
});
