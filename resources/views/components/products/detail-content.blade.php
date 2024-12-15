<head>
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=673c27e404dba600122bb512&product=inline-share-buttons&source=platform"
        async="async"></script>
    <style>
        .glide__slide img {
            width: 100vw;
            height: 25rem;
            object-fit: fill;
            filter: drop-shadow(0 2rem -2rem rgba(0, 0, 0, 0.7));
        }

        #short-description {
            display: none;
        }

        .seller-info {
            display: flex;
            align-items: center;
        }

        .seller-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 20px;
            border: solid 1px rgb(119, 164, 255);
        }

        .glide__arrow {
            color: #333;
            opacity: 0.7;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            padding: 10px;
            transition: opacity 0.3s ease;
        }

        .glide__arrow:hover {
            opacity: 1;
        }

        .glide__arrow--left {
            left: 10px;
        }

        .glide__arrow--right {
            right: 10px;
        }

        .glide__bullet {
            background: #333;
            opacity: 0.7;
            width: 8px;
            height: 8px;
        }

        .glide__bullet--active {
            background: rgb(251, 252, 255);
            opacity: 1;
        }

        .card {
            border: none;
            position: relative;
            border-radius: 0;
        }

        .card:hover {
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Mobile styles */
        @media (max-width: 1200px) {
            .sticky-bottom {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: white;
                padding: 15px;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }
        }

        /* Set a fixed height for the image */
        .fixed-image {
            width: 100%;
            height: 10rem;
            object-fit: cover;
            border-radius: 0;
        }

        /* Custom hover effect with border */
        .hover-underline {
            position: relative;
            text-decoration: none;
        }

        .hover-underline::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #475c7d;
            /* Bootstrap primary color, you can change this */
            transform: scaleX(0);
            transition: transform 0.2s ease-in-out;
        }

        .hover-underline:hover::after {
            transform: scaleX(1);
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
        }

        .wishlist-report-container {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        .wishlist-icon,
        .report-icon {
            background-color: rgba(249, 248, 255, 0.736);
            padding: 8px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .wishlist-icon:hover {
            transform: scale(0.8);
            color: white;
            background-color: rgb(100, 121, 255);
        }

        .report-icon:hover {
            transform: scale(0.8);
            color: white;
            background-color: rgb(255, 100, 100);
        }

        .icon-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    {{-- DYNAMIC TITLE FOR THE PAGE --}}
    @section('title', $marketplaceProducts->prodName . ' | ' . config('app.name'))

</head>

<body>
    <div class="mt-2 container-lg">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                <li class="breadcrumb-item"><small><a href="{{ url('marketplace') }}">Marketplace</a></small></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <small>{{ $marketplaceProducts->prodName }}</small>
                </li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Image Slider Column -->
            <div class="mb-4 col-lg-6">
                <!-- Glide slider container -->
                <div class="glide">
                    <div class="glide__track" data-glide-el="track">
                        <ol class="glide__slides">
                            <li class="glide__slide">

                                <img src="{{ $marketplaceProducts->prodImage && file_exists(public_path('storage/' . $marketplaceProducts->prodImage))
                                    ? asset('storage/' . $marketplaceProducts->prodImage)
                                    : asset('img/NOIMG.jpg') }}"
                                    class="card-img-top fixed-image" alt="{{ $marketplaceProducts->prodName }}">

                            </li>
                        </ol>
                    </div>

                    {{-- WISHLIST-LOGIC --}}
                    @php
                        $isInWishlist =
                            Auth::check() && $marketplaceProducts->wishlists()->where('user_id', Auth::id())->exists();
                    @endphp

                    <div class="wishlist-report-container">
                        <div class="icon-row">
                            <form
                                action="{{ $isInWishlist ? route('wishlist.remove', $marketplaceProducts->wishlists->where('user_id', Auth::id())->first()->id) : route('wishlist.add', $marketplaceProducts->id) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @if ($isInWishlist)
                                    @method('DELETE')
                                    <button type="submit" class="wishlist-icon" title="Remove from Wishlist">
                                        <i class="fas fa-heart" style="color: blue;"></i>
                                    </button>
                                @else
                                    <button type="submit" class="wishlist-icon" title="Add to Wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                @endif
                            </form>

                            <!-- Report Button -->
                            @if (Auth::check())
                                <button class="report-icon" data-bs-toggle="modal" data-bs-target="#reportModal"
                                    title="Report Product">
                                    <i class="fas fa-flag"></i>
                                </button>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current() . '#report']) }}"
                                    class="report-icon" title="Report Product">
                                    <i class="fas fa-flag"></i>
                                </a>
                            @endif

                        </div>
                    </div>


                    <!-- Glide arrows -->
                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i
                                class="fas fa-chevron-left"></i></button>
                        <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i
                                class="fas fa-chevron-right"></i></button>
                    </div>

                    <!-- Glide bullets -->
                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" data-glide-dir="=0"></button>
                        <button class="glide__bullet" data-glide-dir="=1"></button>
                        <button class="glide__bullet" data-glide-dir="=2"></button>
                    </div>

                </div>

                @include('components.products.report-listing-form')

                {{-- SELLER INFO --}}
                <div class="p-3 seller-info d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}">
                            <img src="{{ $marketplaceProducts->author->profile_photo_url }}"
                                alt="{{ $marketplaceProducts->author->name }} IMAGE" class="seller-avatar">
                        </a>
                        <span class="border-b-8"></span>
                        <div>
                            <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}"
                                class="text-dark text-decoration-none hover-underline">
                                <strong>{{ $marketplaceProducts->author->name }}</strong>
                            </a>
                            @if ($marketplaceProducts->author->hasVerifiedEmail())
                                <i class="text-success bi bi-patch-check me-1" data-bs-toggle="tooltip"
                                    title="User is verified"></i>
                            @else
                                <i class="text-danger bi bi-patch-exclamation me-1" data-bs-toggle="tooltip"
                                    title="User is not verified"></i>
                            @endif

                            <div class="text-muted">{{ $marketplaceProducts->author->userAddress }}</div>
                        </div>
                    </div>

                    <div class="p-2 text-sm text-muted">
                        <i class="fas fa-star text-warning"></i>
                        {{ $reviewCount }} {{ Str::plural('reviews', $reviewCount) }}
                    </div>
                </div>

                <hr class="mt-2 d-block">
                <hr class="border-b-2 d-block d-lg-none">
            </div>

            <!-- Product Details Column -->
            <div class="col-lg-6">

                <!-- Seller information -->
                {{-- SHOW STATUS IF SOLD OR NOT --}}
                <div class="flex-wrap d-flex align-items-center justify-content-between w-100">
                    <h1 class="mb-0 h2 fw-bold text-break">{{ $marketplaceProducts->prodName }}
                    </h1>
                    <x-status-badge :status="$marketplaceProducts->status" class="ms-auto" />
                </div>


                <!-- Additional details -->
                <p class="py-1 text-muted d-flex justify-content-between align-items-center">
                    <small>Posted {{ $marketplaceProducts->created_at->diffForHumans() }} •
                        {{ $marketplaceProducts->offers->count() }} chats </small>
                    @if ($marketplaceProducts->featured == true)
                        <small class="text-white badge bg-primary">Featured</small>
                    @endif
                </p>


                <h2 class="py-2 fw-bold h4">₱{{ $marketplaceProducts->prodPrice }} <span
                        class="text-sm text-secondary">/ {{ $marketplaceProducts->price_type }}</span>
                </h2>


                @php
                    $description = $marketplaceProducts->prodDescription;
                    $limitedDescription = Str::limit($description, 300);
                @endphp

                <!-- Product description -->
                <p class="py-2 text-break">
                    <span id="description-text">
                        {{ $limitedDescription }}
                    </span>

                    @if (strlen($description) > 300)
                        <span id="full-description" style="display: none;">
                            {{ $description }}
                        </span>
                        <a href="#" class="text-decoration-none text-primary" id="read-more">Read More</a>
                    @endif
                </p>

                <!-- Product details -->
                <ul class="list-unstyled">

                    <li class="mb-2"><strong>Condition:</strong> {{ $marketplaceProducts->prodCondition }}</li>
                    <li class="mb-2"><strong>Category:</strong> {{ $marketplaceProducts->category->categName }}
                    <li class="mb-2"><strong>Location:</strong> {{ $marketplaceProducts->location }}</li>
                    </li>
                </ul>


                <!-- Conditional buttons based on user authentication, ownership, and product status -->
                @if (Auth::check())
                    @if (Auth::user()->id == $marketplaceProducts->author->id)
                        <!-- Show Edit Product Button if the user is the owner -->
                        <div class="mt-4 mb-2 d-lg-block">
                            <a href="{{ route('listing.edit', $marketplaceProducts->id) }}"
                                class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-edit"></i> EDIT PRODUCT
                            </a>
                        </div>
                    @else
                        @php
                            $allowedStatuses = ['Available', 'Negotiable', 'Fixed'];
                            $isAvailableForOffers = in_array($marketplaceProducts->status, $allowedStatuses);
                        @endphp

                        @if ($isAvailableForOffers)
                            <!-- Offer Button for buyers -->
                            <div class="mt-4 mb-2">
                                <button class="btn btn-outline-primary btn-lg w-100" data-bs-toggle="modal"
                                    data-bs-target="#offerModal">
                                    <i class="fas fa-tags"></i> OFFER
                                    [₱{{ number_format($marketplaceProducts->prodPrice, 2) }}]
                                </button>
                            </div>

                            {{-- LIVEWIRE OFFER-MODAL --}}
                            @livewire('offer-modal', ['product' => $marketplaceProducts])

                            <!-- Chat Button for buyers -->
                            <!-- Button to trigger modal -->
                            {{-- <div class="mb-2 d-lg-block">
                                <a wire:click="message()"
                                    href="{{ route('chat', ['query' => $marketplaceProducts->author->id]) }}"
                                    class="shadow-sm btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                    data-bs-target="#chatModal">
                                    <i class="fas fa-envelope me-2"></i> CHAT WITH SELLER
                                </a>
                            </div> --}}
                            <livewire:message-modal :userId="$marketplaceProducts->author->id" />

                            <!-- Status-specific messages -->
                            @if ($marketplaceProducts->price_type == 'Negotiable')
                                <div class="mt-2 alert alert-info" role="alert">
                                    <i class="fas fa-handshake"></i> Price is negotiable. Feel free to make an
                                    offer!
                                </div>
                            @elseif($marketplaceProducts->status == 'Available')
                                <div class="mt-2 alert alert-success" role="alert">
                                    <i class="fas fa-check-circle"></i> This listing is available for transaction.
                                </div>
                            @elseif($marketplaceProducts->price_type == 'Fixed')
                                <div class="mt-2 alert alert-success" role="alert">
                                    <i class="fas fa-check-circle"></i> This listing is available for transaction.
                                </div>
                            @endif
                        @else
                            <div class="mt-4 mb-2 d-lg-block">
                                <div class="alert alert-secondary" role="alert">
                                    <i class="fas fa-info-circle"></i> This product is currently
                                    <strong>{{ strtolower($marketplaceProducts->status) }}</strong>.
                                    It's not available for new offers or messages at the moment.
                                </div>
                            </div>
                        @endif
                    @endif
                    <!-- ShareThis BEGIN -->
                    <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                @else
                    <!-- Show Login Button if not authenticated -->
                    <div class="mt-4 mb-2 d-lg-block">
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                            class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt"></i> LOGIN TO INTERACT
                        </a>
                    </div>
                    <!-- ShareThis BEGIN -->
                    <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                @endif
            </div>

            <!-- Mobile sticky button -->
            @auth
                @if (Auth::user()->id == $marketplaceProducts->author->id)
                    <div class="d-lg-none sticky-bottom">
                        <a href="{{ route('listing.edit', $marketplaceProducts->id) }}"
                            class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-edit"></i> EDIT PRODUCT
                        </a>
                    </div>
                @else
                    @if ($isAvailableForOffers)
                        <div class="d-lg-none sticky-bottom">
                            <button class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                data-bs-target="#offerModal">
                                <i class="fas fa-tags"></i> MAKE OFFER
                            </button>
                        </div>
                    @endif
                @endif
            @else
                <div class="d-lg-none sticky-bottom">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-sign-in-alt"></i> LOGIN TO INTERACT
                    </a>
                </div>
            @endauth

            <!-- show the seller offers table -->
            <div class="container mt-2">
                @php
                    $isProductOwner = Auth::check() && Auth::id() == $marketplaceProducts->author->id;
                @endphp

                @if ($isProductOwner)
                    @include('seller.offers.offer-table')
                @endif

                {{-- show the buyer sent offers table --}}
                @if (!$isProductOwner)
                    @livewire('product-offers', ['product' => $marketplaceProducts])
                @endif

            </div>
        </div>

        {{-- HAS OTHER LISTING | MARKETPLACECONTROLLER --}}
        @include('components.products.other-listing')

        {{-- SIMILAR LISTINGS / SAME CATEGORY LISTINGS | MARKETPLACECONTROLLER --}}
        @include('components.products.similar-listing')

    </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>

    <script>
        // Initialize Glide slider
        new Glide('.glide', {
            type: 'carousel',
            perView: 1,
            focusAt: 'center',
            keyboard: true,
            breakpoints: {
                767: {
                    perView: 1
                }
            }
        }).mount();
    </script>

    <script>
        $(document).ready(function() {
            $('#read-more').click(function(event) {
                event.preventDefault();

                // Toggle between limited and full description
                $('#description-text').toggle();
                $('#full-description').toggle();

                // Change link text
                if ($('#full-description').is(':visible')) {
                    $(this).text('Read Less');
                } else {
                    $(this).text('Read More');
                }
            });
        });
    </script>
