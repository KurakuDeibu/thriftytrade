<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');

Route::get('/marketplace', [MarketplaceController::class, 'showMarketplace'])->name('marketplace'); // Show Products from Marketplace, and Search
// ->middleware('auth');
Route::get('/marketplace/product/{id}', [MarketplaceController::class, 'showDetails'])->name('product'); //Show Details


// Route::get('/marketplace', [MarketplaceController::class, 'showProductCount'])->name('productCount')->middleware('auth');
// Route::view('/onboard-register','auth.register-onboarding')->name('auth.onboard-register');
// Route::get('/', [MarketplaceController::class,'search'])->name('searchProducts');
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
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [PageController::class, 'show'])->name('dashboard');
});

// ROUTE for Seller in CRUD Products

Route::get('/create/listing', [ProductController::class, 'create'])->name('products.create');
Route::post('/create/listing', [ProductController::class, 'store'])->name('products.store');


Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');


