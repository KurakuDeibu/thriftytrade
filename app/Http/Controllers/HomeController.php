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
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //VIEW FEATURED PRODUCTS FROM LANDING PAGE

        //Added caching to show products
        $featuredProducts = Cache::remember('featuredProducts', Carbon::now()->addHour(5), function () {
        return Products::featured()->latest('created_at')->take(6)->get();
        });
        $categories = Category::orderBy('categName', 'asc')->get();

        // home.blade.php / landing page
        return view('home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories
        ]);

    }

    public function featuredProd()
    {
        // Fetch only featured products with 'featured' = 1
        $featuredProducts = Products::where('featured', 1)->with('author')->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
        ]);
    }

}