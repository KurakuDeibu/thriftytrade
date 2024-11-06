<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index()
    {
        // Get all offers for products where the authenticated user is the seller
        $offers = Offer::whereHas('product', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->with(['product', 'user'])
                ->latest()
                ->get();

        // Group offers by product
        $groupedOffers = $offers->groupBy('products_id');

        // Get total number of pending offers
        $pendingOffersCount = $offers->where('status', 'pending')->count();

        // Get products with no offers
        $productsWithNoOffers = Products::where('user_id', Auth::id())
            ->whereDoesntHave('offers')
            ->get();

        return view('seller.offers.index', compact(
            'groupedOffers',
            'pendingOffersCount',
            'productsWithNoOffers'
        ));
    }

    public function updateStatus(Request $request, Offer $offer)
    {
        // Validate request
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // Verify that the authenticated user is the seller of the product
        if ($offer->product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        try {
            // Update the offer status
            $offer->update(['status' => $request->status]);

            // If offer is accepted, reject all other offers for this product
            if ($request->status === 'accepted') {
                Offer::where('products_id', $offer->products_id)
                    ->where('id', '!=', $offer->id)
                    ->update(['status' => 'rejected']);
            }

            return back()->with('success', 'Offer status updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating the offer status.');
        }
    }

    public function showOffers(Products $product)
    {
        // Verify that the authenticated user is the seller of the product
        if ($product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $offers = $product->offers()->with('user')->latest()->get();

        return view('seller.offers.show', compact('product', 'offers'));
    }
}
