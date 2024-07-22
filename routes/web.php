<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // index page/welcome.blade.php / landing page
});

Route::get('/marketplace', function () {
    return view('marketplace.marketplace-auth'); // index page/welcome.blade.php / landing page
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

