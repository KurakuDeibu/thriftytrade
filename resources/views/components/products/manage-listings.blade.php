{{-- PRODUCT TABS --}}
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h1 class="px-2 text-lg navbar-brand">Manage Listings</h1>
    <a href="{{ route('listing.create') }}">
        <h1 class="btn btn-outline-primary">+ Create New </h1>
    </a>
</div>


<div class="mb-2">
    <!-- Tabs Navigation -->
    <ul class="mb-3 nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button"
                role="tab" aria-controls="active" aria-selected="true">
                Active ({{ $activeProducts }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button"
                role="tab" aria-controls="pending" aria-selected="false">
                Pending (0)
                {{-- Pending ({{ $pendingProducts }}) --}}

            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sold-tab" data-bs-toggle="tab" data-bs-target="#sold" type="button"
                role="tab" aria-controls="sold" aria-selected="false">
                Sold (0)
                {{-- Sold ({{ $soldProducts }}) --}}
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="productTabsContent">
        <!-- Active Products Tab -->
        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
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
                                    <span class="badge position-relative" data-bs-placement="top">
                                        <a href="/marketplace/product/{{ $product->id }}"
                                            class="text-secondary text-decoration-none">
                                            <i
                                                class="border bi bi-eye-fill icon-large bg-light border-light border-3 rounded-3"></i>
                                        </a>
                                        <span class="badge-text">View</span>
                                    </span>

                                    <span class="badge position-relative" data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <a href="{{ route('listing.edit', $product) }}"
                                            class="text-primary text-decoration-none">
                                            <i
                                                class="border bi bi-pencil-square icon-large bg-light border-light border-3 rounded-3"></i>
                                        </a>
                                        <span class="badge-text">Edit</span>
                                    </span>
                                    <span class="badge position-relative" data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                        <a href="{{ route('listing.destroy', $product->id) }}" class="text-danger">
                                            <form action="{{ route('listing.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this product?');">
                                                    <i
                                                        class="border bi bi-trash-fill icon-large bg-light border-light border-3 rounded-3"></i>
                                                    <span class="badge-text">Delete</span>
                                                </button>
                                            </form>
                                        </a>
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
</div>
{{-- END OF PRODUCT TABS --}}
