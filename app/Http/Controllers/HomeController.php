<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        //Added caching to show products
        $featuredProducts = Cache::remember('featuredProducts', Carbon::now()->addHour(5), function () {
        return Product::featured()->latest('created_at')->take(6)->get();
        });

        // home.blade.php / landing page
        return view('home', [
            'featuredProducts' => $featuredProducts
        ]);

    }
}