<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // $transactions = Transaction::where('user_id', Auth::id())
        // ->where('tranStatus', 'completed') // Filter for completed transactions
        // ->with(['transaction','offer', 'product']) // Eager load related offer and product data
        // ->latest()
        // ->get();

        // Fetch accepted offers that are completed, belonging to the current user
        $transactionsseller = Offer::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->where('status', 'completed')
        ->with(['product'])
        ->latest()
        ->get();

          // Transactions (for buyers )
          $transactionsbuyer = Offer::where('user_id', Auth::id())
          ->with(['product', 'user'])
          ->where('status', 'completed')
          ->latest()
          ->get();



            // \Illuminate\Support\Facades\Log::info('Retrieved Transactions: ', $transactions->toArray()); // Log the retrieved transactions


        return view('dashboard', compact(['transactionsbuyer', 'transactionsseller']));
    }
}