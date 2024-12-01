<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // Fetch accepted offers that are sold, belonging to the current user
        $transactions = Offer::whereHas('product', function ($query) {
                $query->where('user_id', Auth::id())
                      ->where('status', 'Sold');
            })
            ->where('status', 'accepted')
            ->with(['product', 'user'])
            ->latest()
            ->get();

        return view('dashboard', compact('transactions'));
    }

    public function showReviewModal(Offer $offer)
    {
        // Ensure the offer belongs to the current user's product
        if ($offer->product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access');
        }

        return view('transactions.review-modal', compact('offer'));
    }
}
