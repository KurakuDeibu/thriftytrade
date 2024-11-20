<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProducts extends Component
{
    use WithPagination;

    public $query = '';
    public $category = null;
    public $condition = null;
    public $featured = false;
    public $sort = 'latest';
    public $price_type = null;
    public $location = null;


    protected $queryString = [
        'query' => ['except' => ''],
        'category' => ['except' => null],
        'condition' => ['except' => null],
        'featured' => ['except' => false],
        'sort' => ['except' => 'latest'],
        'price_type' => ['except' => null],
        'location' => ['except' => null],

    ];

    public function mount()
    {
        $this->query = request('query', '');
        $this->category = request('category');
        $this->condition = request('condition');
        $this->featured = request('featured', false);
        $this->sort = request('sort', 'latest');
        $this->price_type = request('price_type');
        $this->location = request('location');
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::all();

        $query = Products::query();

        // Search filter
        if (!empty($this->query)) {
            $query->where(function ($q) {
                $q->where('prodName', 'like', '%' . $this->query . '%')
                  ->orWhere('prodDescription', 'like', '%' . $this->query . '%');
            });
        }

        // Category filter
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        // Condition filter
        if ($this->condition) {
            $query->where('prodCondition', $this->condition);
        }

        // Featured filter
        if ($this->featured) {
            $query->where('featured', true);
        }

          // Price Type filter
          if ($this->price_type) {
            $query->where('price_type', $this->price_type);
        }

         // Location filter
         if ($this->location) {
            $query->where('location', $this->location);
        }

        // Sorting
        switch ($this->sort) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->orderBy('prodPrice', 'asc');
                break;
            case 'price_high':
                $query->orderBy('prodPrice', 'desc');
                break;
        }

        $marketplaceProducts = $query->paginate(9);

        return view('livewire.search-products', [
            'marketplaceProducts' => $marketplaceProducts,
            'categories' => $categories,
        ]);
    }
}