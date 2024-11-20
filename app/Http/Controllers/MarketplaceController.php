<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{

    // VIEW PRODUCTS, AND SEARCH RESULTS
    public function showMarketplace(Request $request)
{
    // Fetch all categories
    $categories = Category::all();

    // Initialize query builder for products
    $query = Products::query();

    // Handle search query
    $query->when($request->input('query'), function ($q) use ($request) {
        $q->where(function ($subQ) use ($request) {
            $subQ->where('prodName', 'like', '%' . $request->input('query') . '%')
                 ->orWhere('prodDescription', 'like', '%' . $request->input('query') . '%');
        });
    });

    // Handle category filter
    if ($request->has('category') && !empty($request->category)) {
        $category = Category::find($request->category);
        if (!$category) {
            return redirect()->back()->withErrors(['category' => 'Selected category does not exist.']);
        }
        $query->where('category_id', $category->id);
    }

    // Handle condition filter
    if ($request->has('condition') && !empty($request->condition)) {
        $query->where('prodCondition', $request->input('condition'));
    }

    // Handle location filter
    if ($request->has('location') && !empty($request->location)) {
        $query->where('location', $request->location);
    }

    // Handle featured filter
    if ($request->has('featured')) {
        $query->where('featured', true);
    }

   // Handle price type filter
   if ($request->has('price_type') && !empty($request->price_type)) {
    $query->where('price_type', $request->input('price_type'));
    }

    // Handle sorting - default latest
    $sortBy = $request->input('sort', 'latest');
    switch ($sortBy) {
        case 'latest':
            $query->latest();
            break;
        case 'oldest':
            $query->oldest();
            break;
        case 'price_low':
            $query->orderBy('prodPrice', 'asc');
            break;
        case 'price_high':
            $query->orderBy('prodPrice', 'desc');
            break;
    }

    // Paginate results
    $marketplaceProducts = $query->paginate(9);

    return view('marketplace.marketplace-auth', [
        'marketplaceProducts' => $marketplaceProducts,
        'categories' => $categories,
        'query' => $request->input('query'),
        'categoryFilter' => $request->input('category'),
        'conditionFilter' => $request->input('condition'),
        'sortBy' => $sortBy,
        'locationFilter' => $request->input('location'),
        'featuredFilter' => $request->input('featured'),
        'priceTypeFilter' => $request->input('price_type'),
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
        $similarListings = Products::where('category_id', $marketplaceProducts->category_id)
        ->where('id', '!=', $marketplaceProducts->id)
        ->where('prodQuantity', '>', 0) // Ensure the product is in stock
        ->with('author', 'category') // Eager load relationships for performance
        ->take(10) // Limit to 4 recommended products
        ->get();


        return view('products.product-details')->with([
            'marketplaceProducts' => $marketplaceProducts,
            'showOtherListings' => $showOtherListings,
            'hasOtherListings' => $hasOtherListings, // Pass the condition to the view
            'similarListings' => $similarListings,
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
