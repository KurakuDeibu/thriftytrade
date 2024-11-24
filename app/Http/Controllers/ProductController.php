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
        $userProducts = Products::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        $soldProducts = $userProducts->where('status', 'Sold');
        $pendingProducts = $userProducts->where('status', 'Pending');
        $activeProducts = $userProducts->where('status', 'Available');

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
            'userProducts',
            'soldProducts',
            'activeProducts',
            'pendingProducts',
        ));
    }


    public function create()
    {
        // Fetch categories and order them alphabetically by name
        $categories = Category::orderBy('categName', 'asc')->get();

        if (auth()->user() && !auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('error', 'You must verify your email address before you can sell.');
        }
        return view('listing.create', compact('categories'));
    }

    //Add seller's product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|exists:category,id',
            'status' => 'nullable|in:Available,Pending,Sold',
            'price_type' => 'required|in:Fixed,Negotiable',
            'location' => 'required|in:Lapu-Lapu City,Mandaue City',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'condition' => 'required|string|max:20',
            'images' => 'required|image|mimes:jpeg,png,jpg|max:2048'
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
            'status' => 'Available', //set to available
            'price_type' => $request->price_type,
            'location' => $request->location,
            'prodName' => $request->name,
            'prodDescription' => $request->description,
            'prodPrice' => $request->price,
            'prodQuantity' => $request->quantity,
            'prodCondition' => $request->condition,
            'prodImage' => $imagePath,
            'featured' => $request->has('featured')
        ]);


        return redirect()->route('listing.create')->with('success', 'Product listing created successfully.');
    }

    // Redirect to the page where seller can modify the product
    public function edit(Products $product)
    {
        if ($product->user_id !== auth()->id()) {
            return redirect()->route('manage-listing')->with('error', 'Unauthorized access.');
        }
        $categories = Category::orderBy('categName', 'asc')->get();

        return view('listing.edit', compact('product', 'categories'));
    }

    // Update seller's product in the database
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'price_type' => 'required|in:Fixed,Negotiable',
            'location' => 'required|in:Lapu-Lapu City,Mandaue City',
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
            'price_type' => $request->price_type,
            'location' => $request->location,
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

        return redirect()->route('manage-listing')->with('success', 'Listing updated successfully.');
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

    return redirect()->back()->with('success', 'Listing deleted successfully.');
        }

        // --------------------END OF PRODUCT CRUD-----------------------//




        // ------------------START OF PRODUCT OFFERS------------------//
    // - Show offers for a specific product
    public function showProductOffers(Products $product)
    {
        // Verify that the authenticated user is the seller of the product
        if ($product->user_id !== auth()->user()->id()) {
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

    public function markAsSold($id)
    {
        $product = Products::findOrFail($id);

        // Ensure the product belongs to the current user
        if ($product->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to mark this listing as sold.');
        }

        $product->status = 'Sold';
        $product->save();

        return redirect()->back()->with('success', 'Listing marked as sold.');
    }

    public function markAsUnsold($id)
    {
        $product = Products::findOrFail($id);

        if ($product->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to mark this listing as available.');
        }

        $product->status = 'Available';
        $product->save();

        return redirect()->back()->with('success', 'Listing marked as available.');
    }

}
