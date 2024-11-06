<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{

    // VIEW PRODUCTS, AND SEARCH RESULTS
    public function showMarketplace(Request $request)
    {
        $query = $request->input('query');

        if ($query && strlen($query) >= 5) {
            $marketplaceProducts = Products::where(function($q) use ($query) {
                    $q->where('prodName', 'like', "%$query%")
                      ->orWhere('prodDescription', 'like', "%$query%");
                })
                ->paginate(15);
        } else {
            $marketplaceProducts = Products::latest()->paginate(9);
        }

        return view('marketplace.marketplace-auth', [
            'marketplaceProducts' => $marketplaceProducts,
            'query' => $query  // Pass the query to the view
        ]);
    }

    // SHOW PRODUCT DETAILS
    public function showDetails($id)
    {
        $marketplaceProducts = Products::findOrFail($id);

        $showOtherListings = Products::where('user_id', $marketplaceProducts->user_id)
        ->where('id', '!=', $id) // Exclude the current product
        ->latest() // Order them by latest
        ->paginate(5); //

            // Check if there are any other listings
            $hasOtherListings = $showOtherListings->isNotEmpty();

        // dd($showOtherListings);

        return view('products.product-details')->with([
            'marketplaceProducts' => $marketplaceProducts,
            'showOtherListings' => $showOtherListings,
            'hasOtherListings' => $hasOtherListings, // Pass the condition to the view
        ]);
    }

    public function showUserListings($userId)
    {
       // Fetch the user by their ID
        $user = User::findOrFail($userId);
        // Fetch the products listed by the user
        $userProducts = Products::where('user_id', $userId)->latest()->paginate(15);
        $totalProducts = $userProducts->count();

        return view('profile.user-listing', [
            'user' => $user,
            'userProducts' => $userProducts,
            'totalProducts' => $totalProducts
        ]);
    }

}