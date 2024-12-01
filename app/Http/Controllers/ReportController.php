<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    // Predefined reasons for different report types
    private $productReasons = [
        'inappropriate' => 'Inappropriate Content',
        'fraud' => 'Fraudulent Listing',
        'spam' => 'Spam or Scam',
        'misleading' => 'Misleading Information',
        'duplicate' => 'Duplicate Listing',
        'prohibited' => 'Prohibited Item',
        'condition' => 'Misrepresented Condition',
        'copyright' => 'Copyright Infringement',
        'safety' => 'Safety Concern',
        'other' => 'Other'
    ];

    private $userReasons = [
        'harassment' => 'Harassment',
        'inappropriate' => 'Inappropriate Behavior',
        'fraud' => 'Fraudulent Activity',
        'impersonation' => 'Impersonation',
        'spam' => 'Spam or Scam',
        'offensive' => 'Offensive Content',
        'privacy' => 'Privacy Violation',
        'malicious' => 'Malicious Behavior',
        'fake_profile' => 'Fake Profile',
        'other' => 'Other'
    ];

    public function store(Request $request, $id = null)
    {
        // Validate the request
        $validatedData = $request->validate([
            'report_type' => 'required|in:product,user',
            'reason' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $reasons = $request->input('report_type') === 'product'
                        ? array_keys($this->productReasons)
                        : array_keys($this->userReasons);

                    if (!in_array($value, $reasons)) {
                        $fail('Invalid reason selected.');
                    }
                }
            ],
            'details' => 'nullable|string|max:500'
        ]);

        // Prevent self-reporting
        if ($validatedData['report_type'] === 'user' && $id == Auth::id()) {
            return back()->with('error', 'You cannot report yourself.');
        }

        // Preven reporting owned-listing
        if ($validatedData['report_type'] === 'product') {
        $product = Products::findOrFail($id);

        // Check if the current user is the owner of the listing
        if ($product->user_id == Auth::id()) {
            return back()->with('error', 'You cannot report your own listing.');
        }
    }

        // Check if user has already reported this listing
        $existingReport = Report::where([
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);


        if ($validatedData['report_type'] === 'product') {
            // Check if product exists
            $product = Products::findOrFail($id);

            $existingReport->where('products_id', $id);
        } else {
            // Check if user exists
            $reportedUser = User::findOrFail($id);

            $existingReport->where('reported_user_id', $id);
        }

        if ($existingReport->exists()) {
            return back()->with('error', 'You can only report once.');
        }

        // Create the report
        $reportData = [
            'user_id' => Auth::id(),
            'report_type' => $validatedData['report_type'],
            'reason' => $validatedData['reason'],
            'details' => $validatedData['details'] ?? null,
            'status' => 'pending'
        ];

        if ($validatedData['report_type'] === 'product') {
            $reportData['products_id'] = $id;
        } else {
            $reportData['reported_user_id'] = $id;
        }

        Report::create($reportData);

        return back()->with('success', 'Reported successfully. Our team will review it soon.');
    }

    // Method to get reasons (can be used in views if needed)
    public function getReasons($type)
    {
        return $type === 'product' ? $this->productReasons : $this->userReasons;
    }
}
