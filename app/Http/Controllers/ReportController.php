<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request, $productId)
    {
        // Validate the request
        $validatedData = $request->validate([
            'reason' => 'required|in:inappropriate,fraud,spam,misleading,duplicate,other',
            'details' => 'nullable|string|max:500'
        ]);

        // Check if product exists
        $product = Products::findOrFail($productId);

        // Check if user has already reported this product
        $existingReport = Report::where('products_id', $productId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'You have already reported this listing.');
        }

        // Create the report
        $report = Report::create([
            'products_id' => $productId,
            'user_id' => Auth::id(),
            'reason' => $validatedData['reason'],
            'details' => $validatedData['details'] ?? null,
            'status' => 'pending'
        ]);

        //Notify admin (i think it can be implemented on admin)
        // AdminNotification::sendProductReportNotification($report);

        return back()->with('success', 'Listing reported successfully. Our team will review it soon. Thank you!');
    }
}