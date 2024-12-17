<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinderRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $categories = Category::all();

        // Check if user is already a finder or has a pending request
        $user = Auth::user();
        if ($user->isFinder === true) {
            return redirect()->back()->with('success', 'You are already a verified finder.');
        }

        if ($user->finder_status === 'pending') {
            return redirect()->back()->with('info', 'Your finder request is currently under review.');
        }

        return view('finder.finder-registration', compact('categories'));
    }

    public function submitFinderRequest(Request $request)
    {
        $user = Auth::user();

        // Check if the user has already submitted a finder request
        if ($user->finder_status !== 'pending' && $user->finder_status !== 'approved') {
            // Validate the request
            $validatedData = $request->validate([
                'finder_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
                'additional_notes' => 'nullable|string|max:500'
            ]);

            // Store the document
            $documentPath = $request->file('finder_document')->store('finder_documents', 'public');

            // Update user with finder request details
            $user->update([
                'finder_status' => 'pending',
                'finder_document_path' => $documentPath,
                'finder_verification_notes' => $request->input('additional_notes')
            ]);

            return redirect()->route('dashboard')->with('success', 'Finder request submitted successfully. We will review your application soon.');
        } else {
            // If the user has already submitted a request
            return redirect()->route('finder.registration')->with('error', 'You have already submitted a finder request. Please wait for it to be processed.');
        }
    }
}