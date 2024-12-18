<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Offer;
use App\Models\Products;
use App\Models\Transaction;
use App\Notifications\OfferNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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

        // Get sent offers (for buyer)
        $sentOffers = Offer::where('user_id', Auth::id())
        ->with(['product', 'user'])
        ->latest()
        ->get();


            return view('dashboard', compact(
                'groupedOffers',
                'pendingOffers',
                'productsWithNoOffers',
                'acceptedOffers',
                'rejectedOffers',
                'sentOffers'
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

        // Check if the offer exists
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

            // If offer is accepted, update product status to 'Pending'
            if ($request->status === 'accepted') {

                // Update the associated product to 'Pending'
                $offer->product->update([
                    'status' => 'Pending'
                ]);

                // Reject all other offers for this product
                Offer::where('products_id', $offer->products_id)
                    ->where('id', '!=', $offer->id)
                    ->update(['status' => 'rejected']);

                // Notify the buyer of the offer status change
                Notification::send($offer->user, new OfferNotification($offer));


                    $conversation = Conversation::where(function($query) use ($offer) {
                        $query->where('sender_id', Auth::id())
                              ->where('receiver_id', $offer->user_id);
                    })->orWhere(function($query) use ($offer) {
                        $query->where('sender_id', $offer->user_id)
                              ->where('receiver_id', Auth::id());
                    })->first();

                    // If no conversation exists, create a new one
                    if (!$conversation) {
                        $conversation = Conversation::create([
                            'sender_id' => Auth::id(),
                            'receiver_id' => $offer->user_id,
                        ]);
                    }
            }

            return redirect()->back()->with('success', 'Offer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the offer status.');
        }
    }

    //Make the offer to be added on transaction
    public function convertOfferToTransaction(Offer $offer)
    {
        // Validate that the offer is accepted and the user is the product owner
        if ($offer->status !== 'accepted' || $offer->product->user_id !== Auth::id()) {
            return back()->with('error', 'Invalid offer for transaction');
        }

        try {
            DB::beginTransaction();

            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => $offer->user_id, // Buyer
                'products_id' => $offer->products_id,
                'offer_id' => $offer->id,
                'tranDate' => now(),
                'quantity' => 1, // Assuming single item transaction
                'totalPrice' => $offer->offer_price,
                'tranStatus' => 'completed',
                'systemCommission' => $this->calculateSystemCommission($offer->offer_price),
                'finderCommission' => $this->calculateFinderCommission($offer->offer_price)
            ]);

            // Update Product Status to Sold
            $product = $offer->product;
            $product->update([
                'status' => 'Sold',
                'prodQuantity' => max(0, $product->prodQuantity - 1)
            ]);

            // Update Offer Status
            $offer->update(['status' => 'completed']);

            DB::commit();

            return back()->with('success', 'Transaction completed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaction failed: ' . $e->getMessage());
        }
    }

    private function calculateSystemCommission($totalPrice)
    {
        //5% system commission
        return $totalPrice * 0.05;
    }

    private function calculateFinderCommission($totalPrice)
    {
        return $totalPrice * 0.02;
    }

    public function clearDeletedOffers()
    {
        try {
            // Delete offers where the associated product no longer exists
            $deletedOffersCount = Offer::whereHas('product', function ($query) {
                $query->onlyTrashed(); // if it is soft deleted
            })->delete();

            return redirect()->back()->with('success', "Cleared {$deletedOffersCount} offers for deleted products.");
        } catch (\Exception $e) {
            \Log::error('Error clearing deleted offers: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to clear offers. Please try again.');
        }
    }

}