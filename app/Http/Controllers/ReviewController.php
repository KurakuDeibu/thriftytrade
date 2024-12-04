<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function storeReview(Request $request, Offer $transaction)
    {
       // Prevent duplicate reviews
    if ($transaction->hasBeenReviewedByUser(auth()->id())) {
        return back()->with('error', 'You have already reviewed this transaction.');
    }

    $validatedData = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'content' => 'nullable|string',
        'reviewer_id' => 'required|exists:users,id',
        'reviewee_id' => 'required|exists:users,id',
        'offer_id' => 'required|exists:offers,id',
        'products_id' => 'required|exists:products,id',
    ]);

    Review::create($validatedData);

    return back()->with('success', 'Review submitted successfully!');
    }
}