<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index() {

    }

    public function create()
    {
        // Fetch categories and order them alphabetically by name
        $categories = Category::orderBy('categName', 'asc')->get();
        return view('listing.new-listing', compact('categories'));
    }
    //Add seller's product in the database
    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:20',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handling image uploads
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/products', 'public');
                $imagePaths[] = $path;
            }
            $validatedData['prodImage'] = json_encode($imagePaths);
        }

        // Creating product listing
        $product = Products::create([
            'user_id' => auth()->id(),
            'category_id' => $validatedData['category_id'],
            'prodName' => $validatedData['title'],
            'prodDescription' => $validatedData['description'],
            'prodPrice' => $validatedData['price'],
            'prodCondition' => $validatedData['condition'],
            // 'prodImage' => $validatedData['prodImage'] ?? null,
            'featured' => $request->has('featured')
        ]);

        return redirect()->route('products.store')->with('success', 'Product listing created successfully.');
    }

    public function dashboard()
    {
        // Fetch the products that belong to the logged-in user
        $userProducts = Products::where('user_id', auth()->id())->get();

        return view('dashboard', compact('userProducts'));
    }

    // Redirect to the page where seller can modify the product
    public function editProduct(Products $product) {

    }
    // Update seller's product in the database
    public function updateProduct(Request $request, Products $product) {

    }
    //Delete the seller's product in the database
    public function deleteProduct(Products $product) {

    }

    
}
