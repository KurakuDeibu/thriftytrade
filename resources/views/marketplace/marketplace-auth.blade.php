<style>
    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }

    .dashboard-btn {
        background-color: #4267B2;
        color: white;
    }

    .item-card {
        transition: transform 0.3s ease;
    }

    .item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .item-image {
        height: 200px;
        object-fit: cover;
    }

    .item-title {
        font-weight: bold;
    }

    .item-price {
        color: #4267B2;
        font-weight: 500;
    }
</style>



@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                    <li class="breadcrumb-item active"><small><a href="{{ url('marketplace') }}">Marketplace</a></small></li>
                    </li>
                </ol>
            </nav>
            @auth
                @include('layouts.side-bar.side-bar-auth')
            @endauth

            @guest
                @include('layouts.side-bar.side-bar-guest')
            @endguest

            @include('components.search-bar')

            {{-- SHOW ACTIVE FILTERS REQUESTS --}}
            @php
                $activeFilters = [];

                if (request('category')) {
                    $category = \App\Models\Category::find(request('category'));
                    $activeFilters['category'] = [
                        'name' => $category->categName,
                        'type' => 'category',
                    ];
                }

                if (request('condition')) {
                    $activeFilters['condition'] = [
                        'name' => request('condition'),
                        'type' => 'condition',
                    ];
                }

                if (request('featured')) {
                    $activeFilters['featured'] = [
                        'name' => 'Featured listings only',
                        'type' => 'featured',
                    ];
                }
                if (request('location')) {
                    $activeFilters['location'] = [
                        'name' => request('location'),
                        'type' => 'location',
                    ];
                }

            @endphp




            {{-- SHOW ACTIVE FILTER NAMES --}}
            @if (!empty($activeFilters))
                <div class="mb-3 col-12">
                    <div class="alert alert-primary d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Your Active Filters:</span>
                        <div class="flex-wrap gap-2 d-flex">
                            @foreach ($activeFilters as $key => $filter)
                                <div class="badge bg-primary d-flex align-items-center" style="font-size: 0.9rem;">
                                    <span class="me-2">{{ $filter['name'] }}</span>
                                    <a href="{{ request()->fullUrlWithQuery([$filter['type'] => null]) }}"
                                        class="text-white" style="text-decoration: none; margin-left: 5px;">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- End of Active Fitlers --}}

            <!-- CONTENT -->
            <main class="col-lg-12">
                @if ($marketplaceProducts->count() > 0)
                    <div class="py-2 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($marketplaceProducts as $products)
                            <x-products.content-card :products="$products" />
                        @endforeach
                    </div>
                @else
                    <div class="p-4 text-center d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                                class="bi bi-search text-muted" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </div>
                        <h2 class="mb-3 text-muted">No Listings Found</h2>
                        <p class="mb-4 text-muted">
                            We couldn't find any listing matching your search and filter criteria.
                        </p>

                        <div class="gap-3 d-flex">
                            <a href="{{ route('marketplace') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                            </a>
                            <a href="{{ route('listing.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Create New Listing
                            </a>
                        </div>

                        @if (!empty($activeFilters))
                            <div class="mt-4">
                                <h5 class="mb-3 text-muted">Your Current Filters:</h5>
                                <div class="flex-wrap gap-2 d-flex justify-content-center">
                                    @foreach ($activeFilters as $key => $filter)
                                        <span class="badge bg-secondary">
                                            {{ $filter['name'] }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </main>
            <!-- END OF CONTENT -->
        </div>

        {{-- APPENDS ALL THE FILTERS WITH THE PAGINATION --}}
        {{-- PAGINATION --}}
        {{ $marketplaceProducts->appends([
                'query' => request('query'),
                'category' => request('category'),
                'condition' => request('condition'),
                'featured' => request('featured'),
                'sort' => request('sort'),
            ])->links() }}
    </div>
@endsection

<style>
    .badge a:hover {
        opacity: 0.7;
    }
</style>
