<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class ProductController extends Controller
{

    public function dashboard()
    {
        // Fetch the products that belong to the logged-in user
        $userProducts = Products::where('user_id', auth()->id())->get();
        $activeProducts = $userProducts->count();
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
        $acceptedOffers = $offers->where('status', 'accepted');
        $rejectedOffers = $offers->where('status', 'rejected');

        // Get products with no offers
        $productsWithNoOffers = Products::where('user_id', Auth::id())
            ->whereDoesntHave('offers')
            ->get();

        return view('dashboard', compact(
            'groupedOffers',
            'pendingOffersCount',
            'productsWithNoOffers',
            'acceptedOffers',
            'rejectedOffers',
            'userProducts',
            'activeProducts',
        ));
    }


    public function create()
    {
        // Fetch categories and order them alphabetically by name
        $categories = Category::orderBy('categName', 'asc')->get();
        $stats = Status::orderBy('statusName', 'asc')->get();
        return view('listing.create', compact('categories', 'stats'));
    }

    //Add seller's product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:category,id',
            'status_id' => 'required|exists:status,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'condition' => 'required|string|max:20',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $imagePath = null;
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products/images', $imageName, 'public');
        }

        // Creating product listing
        Products::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'status_id' => $request->status_id,
            'prodName' => $request->name,
            'prodDescription' => $request->description,
            'prodPrice' => $request->price,
            'prodQuantity' => $request->quantity,
            'prodCondition' => $request->condition,
            'prodImage' => $imagePath,
            'featured' => $request->has('featured')
        ]);

        // SHOW THE DD() of the created product

        return redirect()->route('listing.create')->with('success', 'Product listing created successfully.');
    }

    // Redirect to the page where seller can modify the product
    public function edit(Products $product)
    {
        if ($product->user_id !== auth()->id()) {
            return redirect()->route('manage-listing')->with('error', 'Unauthorized access.');
        }
        $categories = Category::orderBy('categName', 'asc')->get();
        $stats = Status::orderBy('statusName', 'asc')->get();

        return view('listing.edit', compact('product', 'categories', 'stats'));
    }

    // Update seller's product in the database
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'status_id' => 'required|exists:status,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'condition' => 'required|string|max:20',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Initialize update data
        $updateData = [
            'prodName' => $request->name,
            'prodDescription' => $request->description,
            'category_id' => $request->category_id,
            'status_id' => $request->status_id,
            'prodPrice' => $request->price,
            'prodQuantity' => $request->quantity,
            'prodCondition' => $request->condition,
        ];

        // Handle image upload if a new image is provided
        if ($request->hasFile('images')) {
            // Delete old image if exists
            if ($product->prodImage) {
                Storage::disk('public')->delete($product->prodImage);
            }

            // Store new image
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products/images', $imageName, 'public');

            // Add image path to update data
            $updateData['prodImage'] = $imagePath;
        }

        // Update the product with all the data
        $product->update($updateData);

        return redirect()->route('manage-listing')->with('success', 'Product updated successfully.');
    }

    //Delete the seller's product in the database
    public function destroy($id)
    {
        $product = Products::findOrFail($id);

        if ($product->user_id !== auth()->id()) {
        return redirect()->route('manage-listing')->with('error', 'Unauthorized access.');
    }

    // Delete the product image from storage if it exists
    if ($product->prodImage) {
        Storage::disk('public')->delete($product->prodImage);
    }

    // Delete the product from the database
    $product->delete();

    return redirect()->route('manage-listing')->with('success', 'Product deleted successfully.');
        }

        // --------------------END OF PRODUCT CRUD-----------------------//


        // ------------------START OF PRODUCT OFFERS------------------//
    // - Show offers for a specific product
    public function showProductOffers(Products $product)
    {
        // Verify that the authenticated user is the seller of the product
        if ($product->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $offers = $product->offers()->with('user')->latest()->get();
        return redirect()->route('seller-offers', compact('product', 'offers'));
    }

    // - Update offer status
    public function updateOfferStatus(Request $request, Offer $offer)
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
            return redirect()->route('seller-offers')->with('success', 'Offer updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('seller-offers')->with('error', 'An error occurred while updating the offer status.');
        }
    }
}