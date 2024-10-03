<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{

    // VIEW PRODUCTS, AND SEARCH RESULTS
    public function showMarketplace(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $marketplaceProducts = Products::where('prodName', 'like', "%$query%")
                ->orWhere('prodDescription', 'like', "%$query%")
                ->paginate(15);
        } else {
            $marketplaceProducts = Products::inRandomOrder()->paginate(6);
        }

        return view('marketplace.marketplace-auth')->with('marketplaceProducts', $marketplaceProducts);
    }

    // public function showUserProducts()
    // {
    //     $user_id = auth()->id(); // Get the ID of the authenticated user

    //     $showUserProducts = Product::where('user_id', $user_id)->paginate(15);

    //     return view('layouts.side-bar.side-bar-auth')->with('showUserProducts', $showUserProducts);
    // }

    // PRODUCT DETAILS
    public function showDetails($id)
    {
        $marketplaceProducts = Products::findOrFail($id);
        // $mightAlsoLike = Product::inRandomOrder()->paginate(4);
        return view('products.product-details')->with([
            'marketplaceProducts' => $marketplaceProducts,
            // 'mightAlsoLike' => $mightAlsoLike,
        ]);
    }
}
