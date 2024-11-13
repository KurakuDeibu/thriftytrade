<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Load the user's wishlist items
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function add(Request $request, $productId)
    {
        // Add the product to the wishlist
        Wishlist::updateOrCreate([
            'user_id' => Auth::id(),
            'products_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Listing added to wishlist.');
    }

    public function remove($id)
    {
        // Remove the item from the wishlist
        Wishlist::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Listing removed from wishlist.');
    }
}