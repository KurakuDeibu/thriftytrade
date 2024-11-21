<div class="container-fluid marketplace-listings">
    <div class="mb-4 row align-items-center">
        <div class="col">
            <h1 class="px-2 text-lg navbar-brand">MANAGE LISTINGS</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('listing.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Create New Listing
            </a>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="p-1 mb-4 nav nav-pills bg-light rounded-pill">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#All">
                All ({{ $userProducts->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#active">
                Available ({{ $activeProducts->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending">
                Pending ({{ $pendingProducts->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sold">
                Sold ({{ $soldProducts->count() }})
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content">
        @foreach (['All' => $userProducts, 'active' => $activeProducts, 'pending' => $pendingProducts, 'sold' => $soldProducts] as $tabName => $products)
            <div class="tab-pane fade {{ $tabName == 'All' ? 'show active' : '' }}" id="{{ $tabName }}">
                <div class="row row-cols-1 g-4">
                    @forelse ($products as $product)
                        <div class="col-lg-12">
                            <div
                                class="card listing-card position-relative
                                {{ $product->status == 'Sold' ? 'border-danger sold-listing' : ($product->status == 'Pending' ? 'border-warning pending-listing' : 'border-primary active-listing') }}">
                                <div class="row g-0">
                                    <!-- Product Image and Status Icons -->
                                    <div class="col-md-4 position-relative">
                                        <div class="listing-image-container h-100">
                                            <img src="{{ $product->prodImage && file_exists(public_path('storage/' . $product->prodImage))
                                                ? asset('storage/' . $product->prodImage)
                                                : asset('img/NOIMG.jpg') }}"
                                                class="card-img-top listing-image" alt="{{ $product->prodName }}">

                                            <!-- Status and Condition Icons -->
                                            <div class="top-0 p-2 position-absolute start-0">
                                                <div class="d-flex flex-column">
                                                    <!-- Condition Icon -->
                                                    <span
                                                        class="badge bg-{{ $product->prodCondition == 'New'
                                                            ? 'success'
                                                            : ($product->prodCondition == 'Likely-New'
                                                                ? 'success'
                                                                : ($product->prodCondition == 'Used'
                                                                    ? 'success'
                                                                    : ($product->prodCondition == 'Likely-Used'
                                                                        ? 'success'
                                                                        : 'secondary'))) }} mb-1"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ ucfirst($product->prodCondition) }}">
                                                        {{ ucfirst($product->prodCondition) }}
                                                    </span>

                                                    <!-- Status Icon -->
                                                    <span
                                                        class="badge
                                                    {{ $product->status == 'Available'
                                                        ? 'bg-success'
                                                        : ($product->status == 'Pending'
                                                            ? 'bg-warning'
                                                            : ($product->status == 'Sold'
                                                                ? 'bg-secondary'
                                                                : 'bg-info')) }}"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ ucfirst($product->status) }}">
                                                        @switch($product->status)
                                                            @case('Available')
                                                                <i class="bi bi-check-circle me-1"></i>
                                                            @break

                                                            @case('Pending')
                                                                <i class="bi bi-hourglass-split me-1"></i>
                                                            @break

                                                            @case('Sold')
                                                                <i class="bi bi-bag-x me-1"></i>
                                                            @break

                                                            @default
                                                                <i class="bi bi-question-circle me-1"></i>
                                                        @endswitch
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-8 position-relative">
                                        <div class="card-body h-100 d-flex flex-column">
                                            <div class="mb-3 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="mb-1 card-title">
                                                        {{ Str::limit($product->prodName, 15, '...') }}
                                                    </h5>
                                                    <p class="mb-0 text-muted small">
                                                        {{ $product->category->categName }}
                                                    </p>
                                                </div>

                                                <!-- Listing Actions -->
                                                <div class="gap-2 listing-actions d-flex btn-group">
                                                    <!-- View Product -->
                                                    <a href="/marketplace/product/{{ $product->id }}"
                                                        class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                        title="View Listing">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    <!-- Edit Product -->
                                                    <a href="{{ route('listing.edit', $product) }}"
                                                        class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                                                        title="Edit Listing">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>

                                                    <!-- Delete Product -->
                                                    <button class="btn btn-outline-danger"
                                                        onclick="confirmDelete({{ $product->id }})"
                                                        data-bs-toggle="tooltip" title="Delete Listing">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <div class="mb-1 text-primary h5">
                                                        ₱{{ number_format($product->prodPrice, 2) }}
                                                        <small class="text-muted">{{ $product->price_type }}</small>
                                                    </div>
                                                    <div class="small text-muted">
                                                        <i class="bi bi-geo-alt me-1"></i>{{ $product->location }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <small class="text-muted">
                                                        {{ $product->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>

                                            <hr>

                                            @if ($product->status != 'Sold')
                                                <div class="mt-4">
                                                    <button onclick="updateProductStatus({{ $product->id }}, 'Sold')"
                                                        class="btn btn-outline-secondary w-100">
                                                        <i class="bi bi-check-circle me-1"></i>Mark as Sold
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-4">
                                                    <button
                                                        onclick="updateProductStatus({{ $product->id }}, 'Available')"
                                                        class="btn btn-outline-success w-100">
                                                        <i class="bi bi-check-circle me-1"></i>Unmark as Sold
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="p-5 mt-3 col-12">
                                <div class="text-center alert alert-primary">
                                    No listings in this category.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .listing-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .listing-image-container {
            position: relative;
            overflow: hidden;
        }

        .sold-listing {
            background-color: rgba(49, 54, 64, 0.05) !important;
            border-color: #5f5f5fc1 !important;
            opacity: 0.8;
        }

        .active-listing {
            background-color: rgba(0, 255, 38, 0.05) !important;
            border-color: #03c90d !important;
        }

        .pending-listing {
            background-color: rgba(208, 223, 5, 0.05) !important;
            border-color: #fffc32 !important;
        }

        .listing-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .listing-actions {
            display: flex;
            gap: 5px;
        }

        .btn-group .btn {
            transition: background-color 0.3s ease, color 0.3s ease;
            width: 100%;
            /* Ensures all buttons are the same width */
        }

        .btn-group .btn:hover {
            background-color: rgba(0, 123, 255, 0.1);
            color: #0d6efd;
        }
    </style>

    {{-- SWEET ALERT DIALOG - DELETE --}}
    @push('scripts')
        <script>
            function confirmDelete(productId) {
                swal({
                    title: "Delete Listing",
                    text: "Are you sure you want to delete this listing? This action cannot be undone.",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "btn-secondary"
                        },
                        confirm: {
                            text: "Delete",
                            value: true,
                            visible: true,
                            className: "btn-danger"
                        }
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('listing.destroy', ':id') }}".replace(':id', productId);

                        const csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = '{{ csrf_token() }}';
                        form.appendChild(csrfField);

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>

        <script>
            function updateProductStatus(productId, status) {
                console.log("Updating status for product ID:", productId, "to status:", status); // Debug log

                const statusConfig = {
                    'Sold': {
                        title: 'Mark as Sold',
                        text: 'If you mark this listing as sold, it will be removed from the active listings, and you will no longer receive offers. Are you sure you want to proceed?',
                        icon: 'success',
                        buttonText: 'Mark as Sold',
                        buttonClass: 'btn-secondary'
                    },
                    'Available': {
                        title: 'Unmark as Sold',
                        text: 'Caution: You are about to mark this listing as unsold and available. This action will make the item active for potential buyers. Are you sure you want to proceed?',
                        icon: 'warning',
                        buttonText: 'Unmark as Sold',
                        buttonClass: 'btn-success'
                    }
                };

                const config = statusConfig[status];

                if (!config) {
                    console.error("Invalid status:", status);
                    return;
                }

                swal({
                    title: config.title,
                    text: config.text,
                    icon: config.icon,
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "btn-secondary"
                        },
                        confirm: {
                            text: config.buttonText,
                            value: true,
                            visible: true,
                            className: config.buttonClass
                        }
                    },
                    dangerMode: status === 'Sold',
                }).then((willProceed) => {
                    if (willProceed) {
                        // Create a form to submit the status update
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = status === 'Sold' ?
                            "{{ route('listing.markAsSold', ':id') }}".replace(':id', productId) :
                            "{{ route('listing.markAsUnsold', ':id') }}".replace(':id', productId);

                        // Add CSRF token
                        const csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = '{{ csrf_token() }}';
                        form.appendChild(csrfField);

                        // Add method field to indicate PATCH
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PATCH';
                        form.appendChild(methodField);

                        // Append the form to the body and submit it
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
