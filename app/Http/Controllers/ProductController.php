<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class ProductController extends Controller
{

    public function dashboard()
    {
        // Fetch the products that belong to the logged-in user
        $userProducts = Products::where('user_id', auth()->id())->get();
        $activeProducts = $userProducts->count();

        return view('dashboard', compact('userProducts', 'activeProducts'));
    }


    public function create()
    {
        // Fetch categories and order them alphabetically by name
        $categories = Category::orderBy('categName', 'asc')->get();
        return view('listing.create', compact('categories'));
    }

    //Add seller's product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:20',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        $imagePath = null;
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products/images', $imageName, 'public');
        }
        // Handling image uploads
        // $imagePaths = [];
        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $image) {
        //         $path = $image->store('products', 'public');
        //         $imagePaths[] = $path;
        //     }
        // }
        // $validatedData['prodImage'] = json_encode($imagePaths);


        // Creating product listing
        Products::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'prodName' => $request->name,
            'prodDescription' => $request->description,
            'prodPrice' => $request->price,
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

        return view('listing.edit', compact('product', 'categories'));
    }

    // Update seller's product in the database
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:20',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Initialize update data
        $updateData = [
            'prodName' => $request->name,
            'prodDescription' => $request->description,
            'category_id' => $request->category_id,
            'prodPrice' => $request->price,
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
}