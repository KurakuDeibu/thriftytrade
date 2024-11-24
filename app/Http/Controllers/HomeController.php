<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function featuredProd()
    {
        // Fetch only featured products with 'featured' = true, SHOW ONLY 9 PRODUCTS
        $featuredProducts = Products::where('featured', true)
        ->orderByRaw('CASE
            WHEN status = "Available" THEN 1
            WHEN status = "Pending" THEN 2
            WHEN status = "Sold" THEN 3
            ELSE 4
        END')
        ->with('author')
        ->take(9)
        ->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'sortBy' => request('sort', 'latest'),
            'categoryFilter' => request('category', null),
            'conditionFilter' => request('condition', null)
        ]);
    }

}