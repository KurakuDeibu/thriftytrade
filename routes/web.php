<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FinderRegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WishlistController;
use App\Livewire\Chat\Chat;
use App\Livewire\Chat\Index;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;


// Route::get('/', HomeController::class)->name('home');

// ----------------------HOME CONTROLLER------------------------------//
Route::get('/', [HomeController::class, 'featuredProd'])->name('home');
// -------------------- MARKETPLACE CONTROLLER ---------------------//
Route::get('/marketplace', [MarketplaceController::class, 'showMarketplace'])->name('marketplace'); // Show Products from Marketplace, and Search
Route::get('/marketplace/product/{id}', [MarketplaceController::class, 'showDetails'])->name('product'); //Show Details
Route::get('/marketplace/user/{userId}/listings', [MarketplaceController::class, 'showUserListings'])->name('profile.user-listing'); //Show User Listings

// -----CHAT CONTROLLER - DELETED
    // --------------SENDMESSAGECONTROLLER - CHAT CONTROLLER -------------//
    // Route::get('/marketplace/chat', [SendMessageController::class, 'index'])->name('chat.chat-message');
    // Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // // -----------SEND MESSAGE FROM PRODUCT DETAILS------------//
    // Route::post('/send/messages', [SendMessageController::class, 'store']);
    // // -----------VIEW CHATS FROM CHAT-MESSAGES-----------//
    // Route::get('/users', [SendMessageController::class, 'showUsers']);
    // Route::get('/messages/user/{userId}', [SendMessageController::class, 'showMessages']);
    // Route::post('/send-message', [SendMessageController::class, 'sendMessage']);
    // });

// ------------------------LIVEWIRE-CHAT------------------------------//
Route::middleware('auth')->group(function (){
    Route::get('/chat',Index::class)->name('chat.index');
    Route::get('/chat/{query}',Chat::class)->name('chat');
});

// ----------------------FINDER-CONTROLLER-----------------//
Route::get('/users/finder',Users::class)->name('users.finder');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/become-finder', [FinderRegistrationController::class, 'showRegistrationForm'])->name('finder.registration');
    Route::post('/submit-finder-request', [FinderRegistrationController::class, 'submitFinderRequest'])->name('finder.submit');
});



// --------------------WISHLISTCONTROLLER-------------------------//
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// --------------------REPORTCONTROLLER-------------------------//
Route::middleware(['auth'])->group(function () {
    Route::post('/marketplace/product/{productId}/report', [ReportController::class, 'store'])->name('product.report'); //Listing Report
    Route::post('/user/{userId}/report', [ReportController::class, 'store'])->name('user.report'); // User Report
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
    // -------------------MANAGE LISTINGS--------------------//
    Route::get('/listing/create', [ProductController::class, 'create'])->name('listing.create');
    Route::post('/listing/create', [ProductController::class, 'store'])->name('listing.store');
    Route::get('/listing/{product}/edit', [ProductController::class, 'edit'])->name('listing.edit');
    Route::put('/listing/{product}', [ProductController::class, 'update'])->name('listing.update');
    Route::delete('/listing/{product}', [ProductController::class, 'destroy'])->name('listing.destroy');
});

// ---------------------DASHBOARD VIEW-------------------------//
Route::middleware(['auth', 'verified'])->group( function () {
    // ------MANAGE LISTINGS
    Route::get('/user/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/manage-listing', [ProductController::class, 'dashboard'])->name('manage-listing');
    Route::patch('/listing/{id}/mark-as-sold', [ProductController::class, 'markAsSold'])->name('listing.markAsSold');
    Route::patch('/listing/{id}/mark-as-unsold', [ProductController::class, 'markAsUnsold'])->name('listing.markAsUnsold');

    // ------MANAGE OFFERS------//
    Route::get('/user/offers', [OfferController::class, 'offerdashboard'])->name('seller-offers');
    Route::patch('/user/offers/{offer}/status', [OfferController::class, 'updateOfferStatus'])->name('seller.offers.update-status');
    Route::post('/user/offers/{offer}/complete', [OfferController::class, 'convertOfferToTransaction'])->name('seller.offers.complete');

    // -------MY TRANSACTIONS-----//
    Route::get('/user/transactions', [TransactionController::class, 'index'])->name('user.transactions');
    Route::get('/user/transactions/finder', [TransactionController::class, 'showFinder'])->name('finder.transactions');


    //-------REVIEWCONTROLLER------//
    Route::post('/user/transaction/{transaction}/review', [ReviewController::class, 'storeReview'])->name('transactions.review.store');

    // ------GENERATE REPORTS ------//
    Route::get('/generate-pdf/{offerId}', [TransactionController::class, 'generatePDF'])->name('offers.generate-pdf');

    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'mar`kAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

    // CLEAR ALL - deleted product offers
    Route::delete('/offers/clear-deleted', [OfferController::class, 'clearDeletedOffers'])->name('offers.clear-deleted');

});