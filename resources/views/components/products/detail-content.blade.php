<head>
    <style>
        .glide__slide img {
            width: 100vw;
            height: 25rem;
            object-fit: cover;
            filter: drop-shadow(0 2rem -2rem rgba(0, 0, 0, 0.7));
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
    </style>
</head>

<body>
    <div class="mt-4 container-lg">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                <li class="breadcrumb-item"><small><a href="{{ url('marketplace') }}">Marketplace</a></small></li>
                <li class="breadcrumb-item active" aria-current="page"><small>{{ $marketplaceProducts->prodName }}</small>
                </li>
            </ol>
        </nav>

        <div class="border-b-2 row">
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

                {{-- SELLER INFO --}}
                <div class="p-3 seller-info">
                    <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}">
                        <img src="{{ $marketplaceProducts->author->profile_photo_url }}"
                            alt="{{ $marketplaceProducts->author->name }} IMAGE" class="seller-avatar">
                    </a>

                    <div>
                        <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}"
                            class="text-dark text-decoration-none hover-underline">
                            <strong>{{ $marketplaceProducts->author->name }}</strong>
                        </a>
                        <div class="text-muted">{{ $marketplaceProducts->author->userAddress }}</div>
                    </div>
                </div>
                <div class="border-b-2 d-block d-lg-none">

                </div>
            </div>

            <!-- Product Details Column -->
            <div class="col-lg-6">

                <!-- Seller information -->
                {{-- SHOW STATUS IF SOLD OR NOT --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                    <h1 class="h2 fw-bold text-break mb-0">{{ $marketplaceProducts->prodName }}</h1>
                    <x-status-badge :status="$marketplaceProducts->status->statusName" class="ms-auto" />
                </div>

                <!-- Additional details -->
                <p class="py-1 text-muted d-flex justify-content-between align-items-center">
                    <small>Posted {{ $marketplaceProducts->created_at->diffForHumans() }} • 2 chats </small>
                    @if ($marketplaceProducts->featured == true)
                        <small class="text-white badge bg-primary">Featured</small>
                    @endif
                </p>
                <h2 class="py-2 fw-bold h4">₱{{ $marketplaceProducts->prodPrice }}</h2>

                <!-- Product description -->
                <p class="py-2 text-break">{{ $marketplaceProducts->prodDescription }}</p>

                <!-- Product details -->
                <ul class="list-unstyled">

                    <li class="mb-2"><strong>Condition:</strong> {{ $marketplaceProducts->prodCondition }}</li>
                    <li class="mb-2"><strong>Category:</strong> {{ $marketplaceProducts->category->categName }}
                    </li>
                </ul>


                <!-- Conditional buttons based on user authentication and ownership -->
                @if (Auth::check())
                    @if (Auth::user()->id == $marketplaceProducts->author->id)
                        <!-- Show Edit Product Button if the user is the owner -->
                        <div class="mt-4 mb-2 d-lg-block">
                            {{-- <a href="{{ route('product.edit', $marketplaceProducts->id) }}" --}}
                            <a href="{{ route('listing.edit', $marketplaceProducts->id) }}"
                                class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-edit"></i> EDIT PRODUCT
                            </a>
                        </div>
                    @else
                        <!-- Offer Button for buyers -->
                        <div class="mt-4 mb-2 d-lg-block">
                            <a href="#" class="btn btn-outline-primary btn-lg w-100">OFFER
                                [₱{{ $marketplaceProducts->prodPrice }}]</a>
                        </div>

                        <!-- Chat Button for buyers -->
                        <div class="mb-2 d-lg-block">
                            <a href="#" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-envelope"></i> CHAT WITH SELLER
                            </a>
                        </div>

                        <!-- Chat Button for buyers -->
                        {{-- ----- MESSAGE MODAL - components/Message.blade.php --}}
                        {{-- @include('components.Message') --}}
                        {{-- END OF MESSAGE MODAL --}}
                    @endif
                @else
                    <!-- Show Login Button if not authenticated -->
                    <div class="mt-4 mb-2 d-lg-block">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt"></i> LOGIN TO CHAT
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- CHAT BUTTON (sticky for mobile)  --}}
    @auth
        @if (Auth::user()->id == $marketplaceProducts->author->id)
            <div class="d-lg-none sticky-bottom">
                <a href="{{ route('listing.edit', $marketplaceProducts->id) }}" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-envelope"></i> EDIT PRODUCT
                </a>
            </div>
        @else
            <div class="d-lg-none sticky-bottom">
                <a href="#" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-envelope"></i> CHAT WITH SELLER
                </a>
            </div>
        @endif
    @else
        <div class="d-lg-none sticky-bottom">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-envelope"></i> LOGIN TO CHAT
            </a>
        </div>
    @endauth


    {{-- OTHER LISTINGS OF THE USER --}}
    <div class="container mt-5">
        <div class="mb-4 row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="text-xl font-bold text-center">
                    Other listings by {{ $marketplaceProducts->author->name }}
                </h2>
                <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}"
                    class="font-medium text-blue-500 hover-underline">Show All</a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @if ($hasOtherListings)
                @foreach ($showOtherListings as $product)
                    <div class="col">
                        <a href="/marketplace/product/{{ $product->id }}"
                            class="card h-100 text-decoration-none text-dark">
                            <img src="{{ $product->prodImage && file_exists(public_path('storage/' . $product->prodImage))
                                ? asset('storage/' . $product->prodImage)
                                : asset('img/NOIMG.jpg') }}"
                                class="card-img-top fixed-image" alt="{{ $product->prodName }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ Str::limit($product->prodName, 40, '...') }}</h5>
                                <p class="card-text">₱{{ $product->prodPrice }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="text-center alert alert-primary w-100">No other listings available from this user.</p>
            @endif



        </div>
    </div>

    {{-- RECOMMENDED LISTINGS FOR THE USER --}}
    <div class="container mt-5">
        <div class="mb-4 row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="text-xl font-bold text-center">Recommended Products in ThriftyTrade</h2>
                <a href="#" class="font-medium text-blue-500 hover-underline">Show All</a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @for ($i = 0; $i < 5; $i++)
                <div class="col">
                    <a href="/marketplace/product/{{ $marketplaceProducts->id }}"
                        class="card h-100 text-decoration-none text-dark">
                        <img src="{{ $marketplaceProducts->prodImage && file_exists(public_path('storage/' . $marketplaceProducts->prodImage))
                            ? asset('storage/' . $marketplaceProducts->prodImage)
                            : asset('img/NOIMG.jpg') }}"
                            class="card-img-top fixed-image" alt="{{ $marketplaceProducts->prodName }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::limit($marketplaceProducts->prodName, 40, '...') }}
                            </h5>
                            <p class="card-text">₱{{ $marketplaceProducts->prodPrice }}</p>
                        </div>
                    </a>
                </div>
            @endfor
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
</body>
