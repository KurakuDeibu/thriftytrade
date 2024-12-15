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
        // Only set values if they are actually passed in the request
        $this->query = request('query', '');
        $this->category = request('category') ?: null;
        $this->condition = request('condition') ?: null;
        $this->featured = request('featured') ?: null;
        $this->sort = request('sort', 'latest');
        $this->price_type = request('price_type') ?: null;
        $this->location = request('location') ?: null;
    }

    public function updatingSearch()
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

        // Order to prioritize available products first to show in
        $query->orderByRaw('CASE
            WHEN status = "Available" THEN 1
            WHEN status = "Pending" THEN 2
            WHEN status = "Sold" THEN 3
            ELSE 4
        END');

        // Sorting - CASE
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

        //  // Sorting - IF ELSE
        //  if ($this->sort === 'latest') {
        //     $query->latest();
        // } elseif ($this->sort === 'oldest') {
        //     $query->oldest();
        // } elseif ($this->sort === 'price_low') {
        //     $query->orderBy('prodPrice', 'asc');
        // } elseif ($this->sort === 'price_high') {
        //     $query->orderBy('prodPrice', 'desc');
        // }

        $marketplaceProducts = $query->paginate(9);

        return view('livewire.search-products', [
            'marketplaceProducts' => $marketplaceProducts,
            'categories' => $categories,
            'activeFilters' => $this->getActiveFilters(),
        ]);
    }

    // Method to get active activeFilters for display
    public function getActiveFilters()
    {
        $filters = [];

        if ($this->featured) {
            $filters['featured'] = [
                'name' => 'Featured Listings',
                'type' => 'featured'
            ];
        }

        if ($this->category) {
            $category = Category::find($this->category);
            $filters['category'] = [
                'name' => $category->categName,
                'type' => 'category'
            ];
        }

        if ($this->condition) {
            $filters['condition'] = [
                'name' => $this->condition,
                'type' => 'condition'
            ];
        }

        if ($this->location) {
            $filters['location'] = [
                'name' => $this->location,
                'type' => 'location'
            ];
        }

        if ($this->price_type) {
            $filters['price_type'] = [
                'name' => $this->price_type,
                'type' => 'price_type'
            ];
        }

        return $filters;
    }

    // Method to remove a specific filter
    public function removeFilter($filterType)
    {
        switch ($filterType) {
            case 'featured':
                $this->featured = null;
                break;
            case 'category':
                $this->category = null;
                break;
            case 'condition':
                $this->condition = null;
                break;
            case 'location':
                $this->location = null;
                break;
            case 'price_type':
                $this->price_type = null;
                break;
            case 'sort':
                $this->sort = null;
                break;
        }
    }
}