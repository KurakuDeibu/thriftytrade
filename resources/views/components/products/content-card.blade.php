@props(['products'])
<div class="col">
    @php
        // Determine the status class
        $statusClass = match ($products->status) {
            'Available' => 'status-card-available',
            'Pending' => 'status-card-pending',
            'Sold' => 'status-card-sold',
            default => 'status-card-available',
        };
    @endphp
    <div
        class="transition bg-white border-0 shadow-sm card h-100 item-card status-card {{ $statusClass }} {{ $products->featured ? 'featured-card' : '' }}">
        <div class="position-relative">
            <div class="image-container">
                <img src="{{ $products->prodImage && file_exists(public_path('storage/' . $products->prodImage))
                    ? asset('storage/' . $products->prodImage)
                    : asset('img/NOIMG.jpg') }}"
                    class="card-img-top item-image" alt="{{ $products->prodName }}">
            </div>

            @if ($products->featured)
                <div class="top-0 m-2 badge bg-primary position-absolute end-0">Featured</div>
            @endif

            @php
                $isInWishlist = Auth::check() && $products->wishlists()->where('user_id', Auth::id())->exists();
            @endphp

            <div class="position-relative">
                <form
                    action="{{ $isInWishlist ? route('wishlist.remove', $products->wishlists->where('user_id', Auth::id())->first()->id) : route('wishlist.add', $products->id) }}"
                    method="POST" class="top-0 m-2 position-absolute end-0">
                    @csrf
                    @if ($isInWishlist)
                        @method('DELETE')
                        <button type="submit" class="wishlist-icon" title="Remove from Wishlist">
                            <i class="p-2 fas fa-heart" style="color: blue;"></i>
                        </button>
                    @else
                        <button type="submit" class="wishlist-icon" title="Add to Wishlist">
                            <i class="p-2 far fa-heart"></i>
                        </button>
                    @endif
                </form>
            </div>

            <button class="btn btn-outline-primary quick-view" data-bs-toggle="modal"
                data-bs-target="#quickViewModal{{ $products->id }}">
                <i class="fas fa-search"></i> Quick View
            </button>
        </div>

        <a href="/marketplace/product/{{ $products->id }}" class="text-decoration-none">
            <div class="card-body d-flex flex-column">
                <h5 class="mb-2 card-title item-title">{{ Str::limit($products->prodName, 25, '...') }}</h5>
                <p class="mb-3 text-lg card-text item-title fw-bold">₱{{ number_format($products->prodPrice, 2) }}
                </p>

                <div class="mt-auto">
                    <p class="mb-1 card-text text-muted">
                        <x-status-badge :status="$products->status" />
                    </p>
                    <p class="card-text text-muted"><i
                            class="far fa-clock me-2"></i>{{ $products->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal{{ $products->id }}" tabindex="-1"
    aria-labelledby="quickViewModalLabel{{ $products->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-end modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewModalLabel{{ $products->id }}">{{ $products->prodName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 image-container">
                            <img src="{{ $products->prodImage && file_exists(public_path('storage/' . $products->prodImage))
                                ? asset('storage/' . $products->prodImage)
                                : asset('img/NOIMG.jpg') }}"
                                class="rounded img-fluid" alt="{{ $products->prodName }}">
                        </div>
                        <div class="seller-info d-flex align-items-center">
                            <img src="{{ $products->author->profile_photo_url }}" alt="{{ $products->author->name }}"
                                class="rounded-circle me-2" style="width: 40px; height: 40px;">
                            <div>
                                <h6 class="mb-0">{{ $products->author->name }}</h6>
                                <small class="text-muted">{{ $products->author->userAddress }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-details">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 price">₱{{ number_format($products->prodPrice, 2) }} <span
                                        class="text-sm text-secondary">/ {{ $products->price_type }}</span></h4>

                                @if (Auth::check() && Auth::user()->id == $products->author->id)
                                    <a href="/listing/{{ $products->id }}/edit" class="btn btn-outline-secondary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @else
                                    <!-- Wishlist Icon in Quick View -->
                                    @php
                                        $isInWishlist =
                                            Auth::check() &&
                                            $products->wishlists()->where('user_id', Auth::id())->exists();
                                    @endphp

                                    <form
                                        action="{{ $isInWishlist ? route('wishlist.remove', $products->wishlists->where('user_id', Auth::id())->first()->id) : route('wishlist.add', $products->id) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @if ($isInWishlist)
                                            @method('DELETE')
                                            <button type="submit" class="wishlist-icon" title="Remove from Wishlist">
                                                <i class="fas fa-heart" style="color: blue ;"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="wishlist-icon" title="Add to Wishlist">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Category:</span>
                                <span class="detail-value">{{ $products->category->categName }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Condition:</span>
                                <span class="detail-value">{{ $products->prodCondition }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status:</span>
                                <span class="detail-value">{{ $products->status }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Posted:</span>
                                <span class="detail-value">{{ $products->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Location:</span>
                                <span class="detail-value">{{ $products->location }}</span>
                            </div>
                            <div class="mt-3">
                                <h6>Description:</h6>
                                <div class="mt-3 description-box">
                                    <p>{{ Str::limit($products->prodDescription, 100, '...') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="/marketplace/product/{{ $products->id }}">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">View Full
                        Details</button>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #3498db;
        --primary-light: #ebf5fb;
        --text-color: #2c3e50;
        --light-gray: #ecf0f1;
    }

    .item-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .featured-card {
        background: linear-gradient(145deg, #007bff, #95b7ff);
        color: white;
    }

    .image-container {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-container img {
        object-fit: fill;
        width: 100%;
        height: 100%;
    }

    .description-box {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        background-color: #f9f9f9;
        max-height: 150px;
        overflow-x: hidden;
    }

    .quick-view {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        background-color: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    .item-card:hover .quick-view {
        opacity: 0.5;
    }

    .quick-view:hover {
        opacity: 1 !important;
        background-color: var(--primary-color);
        color: white;
    }

    .modal-dialog-end {
        position: fixed;
        margin: auto;
        width: 90%;
        max-width: 800px;
        height: 100%;
        right: 0;
        top: 0;
    }

    .modal-dialog-end .modal-content {
        height: 100%;
        border-radius: 0;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    }

    .modal-header,
    .modal-footer {
        background-color: var(--primary-light);
        border: none;
    }

    .modal-body {
        padding: 2rem;
        overflow-y: auto;
    }

    .modal.fade .modal-dialog-end {
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog-end {
        transform: translateX(0);
    }

    .product-details .price {
        color: var(--primary-color);
        font-weight: bold;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .detail-row .label {
        font-weight: bold;
    }
</style>
