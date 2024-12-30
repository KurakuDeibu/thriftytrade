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
    public $categories = [];
    public $condition = null;
    public $featured = false;
    public $is_looking_for = false;
    public $sort = 'latest';
    public $price_type = null;
    public $location = null;


    protected $queryString = [
        'query' => ['except' => ''],
        'categories' => ['except' => []],
        'condition' => ['except' => null],
        'featured' => ['except' => false],
        'is_looking_for' => ['except' => false],
        'sort' => ['except' => 'latest'],
        'price_type' => ['except' => null],
        'location' => ['except' => null],

    ];

    public function mount()
    {
        // Only set values if they are actually passed in the request
        $this->query = request('query', '');
        $this->categories = request('categories', []);
        $this->condition = request('condition') ?: null;
        $this->featured = request('featured') ?: null;
        $this->is_looking_for = request('is_looking_for') ?: null;
        $this->sort = request('sort', 'latest');
        $this->price_type = request('price_type') ?: null;
        $this->location = request('location') ?: null;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Products::query();

        // Search filter
        if (!empty($this->query)) {
            $query->where(function ($q) {
                $q->where('prodName', 'like', '%' . $this->query . '%')
                  ->orWhere('prodDescription', 'like', '%' . $this->query . '%');
            });
        }

        // Category filter
        if (!empty($this->categories)) {
            $query->whereIn('category_id', $this->categories);
        }

        // Condition filter
        if ($this->condition) {
            $query->where('prodCondition', $this->condition);
        }

        // Featured filter
        if ($this->featured) {
            $query->where('featured', true);
        }

        // Looking for filter
        if ($this->is_looking_for) {
            $query->where('is_looking_for', true);
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
            'activeFilters' => $this->getActiveFilters(),
        ]);
    }

    // Method to get active activeFilters for display
    public function getActiveFilters()
    {
        $filters = [];

        if (!empty($this->query)) {
            $filters[] = ['type' => 'query', 'name' => "Search: {$this->query}"];
        }

        if (!empty($this->categories)) {
            $categoryNames = Category::whereIn('id', $this->categories)->pluck('categName')->toArray();
            $filters['categories'] = [
                'name' => implode(', ', $categoryNames),
                'type' => 'categories'
            ];
        }


        if ($this->featured) {
            $filters[] = ['type' => 'featured', 'name' => 'Featured Listings'];
        }

        if ($this->is_looking_for) {
            $filters[] = ['type' => 'is_looking_for', 'name' => 'Looking For Listings'];
        }

        if ($this->condition) {
            $filters[] = ['type' => 'condition', 'name' => "Condition: {$this->condition}"];
        }

        if ($this->location) {
            $filters[] = ['type' => 'location', 'name' => "Location: {$this->location}"];
        }

        if ($this->price_type) {
            $filters[] = ['type' => 'price_type', 'name' => "Price Type: {$this->price_type}"];
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
             case 'is_looking_for':
                $this->is_looking_for = null;
                break;
            case 'query':
                $this->query = '';
                break;
            case 'categories':
                $this->categories = [];
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