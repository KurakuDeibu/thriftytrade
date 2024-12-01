<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function offerdashboard()
    {
        $offers = Offer::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->with(['product', 'user'])
        ->latest()
        ->get();

        // Group offers by product
        $groupedOffers = $offers->groupBy('products_id');

        // Get total number of pending offers
        $pendingOffers = $offers->where('status', 'pending');
        $acceptedOffers = $offers->where('status', 'accepted');
        $rejectedOffers = $offers->where('status', 'rejected');

        // Get products with no offers
        $productsWithNoOffers = Products::where('user_id', Auth::id())
            ->whereDoesntHave('offers')
            ->get();

            return view('dashboard', compact(
                'groupedOffers',
                'pendingOffers',
                'productsWithNoOffers',
                'acceptedOffers',
                'rejectedOffers',
                ));
    }

    // ------------------START OF PRODUCT OFFERS------------------//


    // - Update offer status
    public function updateOfferStatus(Request $request, Offer $offer)
    {
        // Validate request
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        // check if the offer exists
        if (!$offer) {
            return back()->with('error', 'Offer not found.');
        }

        $offer->load('product');

        if (!$offer->product || $offer->product->user_id !== Auth::id()) {
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
            return redirect()->route('seller-offers')->with('success', 'Offer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('seller-offers')->with('error', 'An error occurred while updating the offer status.');
        }
    }
}