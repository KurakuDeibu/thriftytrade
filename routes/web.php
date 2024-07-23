<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::get('/marketplace', function () {
    return view('marketplace.marketplace-auth'); // index page/welcome.blade.php / landing page
});

Route::get('/create/listing', function () {
    return view('listing.new-listing'); 
});

Route::get('/marketplace/product/3', function () {
    return view('products.product-details'); 
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

