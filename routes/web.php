<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


// Route::get('/', HomeController::class)->name('home');

Route::get('/marketplace', [MarketplaceController::class, 'showMarketplace'])->name('marketplace'); // Show Products from Marketplace, and Search
// ->middleware('auth');
Route::get('/marketplace/product/{id}', [MarketplaceController::class, 'showDetails'])->name('product'); //Show Details

Route::get('/marketplace/user/{userId}/listings', [MarketplaceController::class, 'showUserListings'])->name('profile.user-listing'); //Show User Listings

Route::get('/marketplace/chat', [ChatController::class, 'index'])->name('chat.chat-message');
// Route::get('/marketplace', [MarketplaceController::class, 'showProductCount'])->name('productCount')->middleware('auth');
// Route::view('/onboard-register','auth.register-onboarding')->name('auth.onboard-register');
// Route::get('/', [MarketplaceController::class,'search'])->name('searchProducts');
// Route::get('/create/listing', function () {
//     return view('listing.create');
// });



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/listing/create', function () {
        return view('listing.create');
    })->name('create');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    // Route::get('/dashboard', [PageController::class, 'show'])->name('dashboard');
});

// ROUTE for Seller in CRUD Products
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
Route::get('/listing/create', [ProductController::class, 'create'])->name('listing.create');
Route::post('/listing/create', [ProductController::class, 'store'])->name('listing.store');
Route::get('/listing/{product}/edit', [ProductController::class, 'edit'])->name('listing.edit');
Route::put('/listing/{product}', [ProductController::class, 'update'])->name('listing.update');
Route::delete('/listing/{product}', [ProductController::class, 'destroy'])->name('listing.destroy');
});


Route::get('/user/dashboard', [ProductController::class, 'dashboard'])->name('dashboard')->middleware('auth','verified');
Route::get('/user/manage-listing', [ProductController::class, 'dashboard'])->name('manage-listing')->middleware('auth','verified');

Route::get('/', [HomeController::class, 'featuredProd'])->name('home');
