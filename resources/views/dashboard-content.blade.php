<div class="mb-4 d-flex justify-content-between align-items-center">
    <h1 class="navbar-brand">{{ Auth::user()->name }}'s' Dashboard</h1>
</div>

{{-- @foreach ($featuredProducts as $products) --}}

<div class="mb-4 row">
    <div class="mb-3 col-md-3">
        <div class="p-3 bg-white rounded stat-card-custom">
            <div class="text-muted">Active Listings</div>
            <div class="h4">{{ $activeProducts }}</div>
        </div>
    </div>

    {{-- @endforeach --}}

    <div class="mb-3 col-md-3">
        <div class="p-3 bg-white rounded stat-card-custom">
            <div class="text-muted">Items Sold</div>
            <div class="h4">0</div>
        </div>
    </div>
    <div class="mb-3 col-md-3">
        <div class="p-3 bg-white rounded stat-card-custom">
            <div class="text-muted">Total Earnings</div>
            <div class="h4">₱
                {{ Auth::user()->products->sum('price') }}
            </div>
        </div>
    </div>
    <div class="mb-3 col-md-3">
        <div class="p-3 bg-white rounded stat-card-custom">
            <div class="text-muted">Average Rating</div>
            <div class="h4">5 <span class="h6">/ 5</span></div>
        </div>
    </div>
</div>

{{-- PRODUCT TABS --}}
{{-- <div class="mb-2">
    <!-- Tabs Navigation -->
    <ul class="mb-3 nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-tab" data-bs-toggle="tab"
                data-bs-target="#active" type="button" role="tab" aria-controls="active"
                aria-selected="true">
                Active ({{ $activeProducts }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                type="button" role="tab" aria-controls="pending" aria-selected="false">
                Pending (0)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sold-tab" data-bs-toggle="tab" data-bs-target="#sold"
                type="button" role="tab" aria-controls="sold" aria-selected="false">
                Sold (0)
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="productTabsContent">
        <!-- Active Products Tab -->
        <div class="tab-pane fade show active" id="active" role="tabpanel"
            aria-labelledby="active-tab">
            <div class="row">
                @if ($activeProducts == 0)
                    <div class="text-center alert alert-primary" role="alert">
                        No active products.
                    </div>
                @else
                    @foreach ($userProducts as $product)
                        <div class="mb-4 col-md-6">
                            <div class="card h-100 text-decoration-none text-dark">
                                <img src="{{ asset('storage/' . $product->prodImage) }}"
                                    class="card-img-top fixed-image" alt="{{ $product->prodName }}">

                                <!-- Badge Icon -->
                                <div class="badge-container">
                                    <span class="badge bg-info position-relative"
                                        data-bs-placement="top" title="View">
                                        <a href="/marketplace/product/{{ $product->id }}"
                                            class="text-white text-decoration-none">
                                            <i class="bi bi-eye icon-large"></i>
                                        </a>
                                        <span class="badge-text">View</span>
                                    </span>

                                    <span class="badge bg-primary position-relative"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Edit">
                                        <a href="/marketplace/product/{{ $product->id }}/edit"
                                            class="text-white text-decoration-none">
                                            <i class="bi bi-pencil icon-large"></i>
                                        </a>
                                        <span class="badge-text">Edit</span>
                                    </span>

                                    <span class="badge bg-danger position-relative"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Delete">
                                        <a href="/marketplace/product/{{ $product->id }}/delete"
                                            class="text-white text-decoration-none">
                                            <i class="bi bi-trash icon-large"></i>
                                        </a>
                                        <span class="badge-text">Delete</span>
                                    </span>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ Str::limit($product->prodName, 40, '...') }}</h5>
                                    <p class="card-text">₱{{ $product->prodPrice }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div> <!-- end row -->
        </div>

        <!-- Pending Tab -->
        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <!-- Add pending products content here -->
            <div class="text-center alert alert-primary" role="alert">
                No pending products.
            </div>
        </div>

        <!-- Sold Tab -->
        <div class="tab-pane fade" id="sold" role="tabpanel" aria-labelledby="sold-tab">
            <!-- Add sold products content here -->
            <div class="text-center alert alert-primary" role="alert">
                No sold products.
            </div>
        </div>
    </div>
</div> --}}
{{-- END OF PRODUCT TABS --}}

{{-- @foreach ($userProducts as $products)
    <x-partials.product-card :products="$products" />
@endforeach --}}
