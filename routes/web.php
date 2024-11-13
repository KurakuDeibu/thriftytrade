<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\WishlistController;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Route;


// Route::get('/', HomeController::class)->name('home');

// ----------------------HOME CONTROLLER------------------------------//
Route::get('/', [HomeController::class, 'featuredProd'])->name('home');
// -------------------- MARKETPLACE CONTROLLER ---------------------//
Route::get('/marketplace', [MarketplaceController::class, 'showMarketplace'])->name('marketplace'); // Show Products from Marketplace, and Search
Route::get('/marketplace/product/{id}', [MarketplaceController::class, 'showDetails'])->name('product'); //Show Details
Route::get('/marketplace/user/{userId}/listings', [MarketplaceController::class, 'showUserListings'])->name('profile.user-listing'); //Show User Listings

// ---------------------SENDMESSAGECONTROLLER - CHAT CONTROLLER --------------------------//
Route::get('/marketplace/chat', [ChatController::class, 'index'])->name('chat.chat-message');
// Route::get('/marketplace/chat', [SendMessageController::class, 'index'])->name('chat.chat-message');
// Route::post('/send/messages', [SendMessageController::class, 'store']);
// Route::get('/users', [SendMessageController::class, 'showUsers']);
// Route::get('/messages/user/{userId}', [SendMessageController::class, 'showMessages']);


// --------------------WISHLISTCONTROLLER-------------------------//
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

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


// ---------------------- SELLER ProductController -----------------//
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/listing/create', [ProductController::class, 'create'])->name('listing.create');
    Route::post('/listing/create', [ProductController::class, 'store'])->name('listing.store');
    Route::get('/listing/{product}/edit', [ProductController::class, 'edit'])->name('listing.edit');
    Route::put('/listing/{product}', [ProductController::class, 'update'])->name('listing.update');
    Route::delete('/listing/{product}', [ProductController::class, 'destroy'])->name('listing.destroy');
});

// ---------------------DASHBOARD VIEW-------------------------//
Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/user/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/manage-listing', [ProductController::class, 'dashboard'])->name('manage-listing');
    Route::get('/user/offers', [ProductController::class, 'dashboard'])->name('seller-offers');
    // ---------------UPDATE THE STATUS---------------//
    Route::patch('/user/offers/{offer}/status', [ProductController::class, 'updateOfferStatus'])->name('seller.offers.update-status');
    Route::patch('/user/offers/product/{product}', [ProductController::class, 'updateOfferStatus'])->name('seller.offers.update-status');

});