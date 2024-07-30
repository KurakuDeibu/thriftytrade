<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');

Route::get('/marketplace', [MarketplaceController::class, 'showMarketplace'])->name('marketplace');
// ->middleware('auth');

// Route::get('layouts.side-bar.side-bar-auth', [MarketplaceController::class, 'showUserProducts'])->name('showUserProducts')->middleware('auth');
// Route::get('/marketplace', [MarketplaceController::class, 'showProductCount'])->name('productCount')->middleware('auth');

Route::view('/onboard-register','auth.register-onboarding')->name('auth.onboard-register');

// Route::get('/', [MarketplaceController::class,'search'])->name('searchProducts');

Route::get('/dashboard', function () {
    return view('dashboard');  //landing page
})->name('dashboard');


// Route::get('/marketplace/product/3', function () {
//     return view('products.product-details'); 
// });

Route::get('/marketplace/product/{id}', [MarketplaceController::class, 'showDetails'])->name('product');

// Route::get('/create/listing', function () {
//     return view('listing.new-listing'); 
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/create/listing', function () {
        return view('listing.new-listing');
    })->name('new-listing');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
