<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Products;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class TransactionController extends Controller
{
    public $selectedOffer = null;

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

    public function generatePDF($offerId)
    {
        // Fetch the offer with its related models
        $selectedOffer = Offer::with([
            'product',
            'product.author',
            'product.category',
            'user'
        ])->findOrFail($offerId);

        // Check if the current user is authorized
        if (
            Auth::id() !== $selectedOffer->user_id &&
            Auth::id() !== $selectedOffer->product->user_id
        ) {
            abort(403, 'Unauthorized access');
        }

        // Generate PDF
        $pdf = FacadePdf::loadView('pdf.generate-transaction-details', [
            'selectedOffer' => $selectedOffer,
        ]);

        // Optional: Customize PDF
        $pdf->setPaper('a4', 'portrait');

        // Download the PDF
        return $pdf->stream('transaction-details-' . $offerId . '.pdf');
        // return $pdf->download('transaction-details-' . $offerId . '.pdf');
    }

    public function showFinder()
    {
        // Transactions (for finders )
        $transactionsfinder = Transaction::whereHas('offer', function ($query) {
            $query->where('user_id', Auth::id());
        })
          ->where('tranStatus', 'completed')
          ->with(['offer', 'user'])
          ->latest()
          ->get();

        return view('dashboard', compact(['transactionsfinder']));
    }
    //    // Transactions (for finders )
    //    $transactionsfinder = Transaction::whereHas('offer', function ($query) {
    //     $query->where('user_id', Auth::id());
    // })
    //   ->where('tranStatus', 'completed')
    //   ->with(['offer', 'user'])
    //   ->latest()
    //   ->get();
}