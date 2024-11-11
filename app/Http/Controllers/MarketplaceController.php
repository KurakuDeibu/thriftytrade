<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Products;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{

    // VIEW PRODUCTS, AND SEARCH RESULTS
    public function showMarketplace(Request $request)
    {
        $query = $request->input('query');
        $categoryFilter = $request->input('category');
        $conditionFilter = $request->input('condition');
        $locationFilter = $request->input('location');
        $sortBy = $request->input('sort', 'latest'); //Default to latest
        $featuredFilter = $request->input('featured');
        $statusFilters = $request->input('status', []); // Default to empty array

        // MARKETPLACE CONTENTS AND QUERY
        $marketplaceProducts = Products::when($query, function($q) use ($query) {
                return $q->where(function($subQ) use ($query) {
                    $subQ->where('prodName', 'like', "%$query%")
                        ->orWhere('prodDescription', 'like', "%$query%");
                });
            })

            // Category Fitler
            ->when($categoryFilter, function($q) use ($categoryFilter) {
                return $q->where('category_id', $categoryFilter);
            })

            // Condtion Filter
            ->when($conditionFilter , function($q) use ($conditionFilter) {
                return $q->where('prodCondition', $conditionFilter);
            })

            // Featured Filter
            ->when($featuredFilter, function($q) {
                return $q->where('featured', true);
            })

            // Status Filter (multiple status)
            ->when($statusFilters, function($q) use ($statusFilters) {
                return $q->whereIn('status', $statusFilters);
            })

            // SORTING
            ->when($sortBy, function($q) use ($sortBy) {
                switch ($sortBy) {
                    case 'latest':
                        return $q->latest();
                    case 'oldest':
                        return $q->oldest();
                    case 'price_low':
                        return $q->orderBy('prodPrice', 'asc');
                    case 'price_high':
                        return $q->orderBy('prodPrice', 'desc');
                    default:
                        return $q->latest();
                }
            })

            // PAGINATE 9 PRODUCTS
            ->paginate(9);

        return view('marketplace.marketplace-auth', [
            'marketplaceProducts' => $marketplaceProducts,
            'query' => $query,
            'categoryFilter' => $categoryFilter,
            'conditionFilter' => $conditionFilter,
            'sortBy' => $sortBy,
            'featuredFilter' => $featuredFilter,
            'statusFilters' => $statusFilters,
        ]);
    }

    // SHOW PRODUCT DETAILS
    public function showDetails($id)
    {
        $marketplaceProducts = Products::findOrFail($id);

        $showOtherListings = Products::where('user_id', $marketplaceProducts->user_id)
        ->where('id', '!=', $id) // Exclude the current product
        ->latest() // Order them by latest
        ->paginate(5); //Paginate 5 otherlistings of the user

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