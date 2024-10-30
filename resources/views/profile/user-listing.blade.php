<html>

<head>
    <base href="">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }}'s Listings</title>
    <style>
        .profile-header {
            background-color: #e6e7e85b;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 20px;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .item-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }

        .card {
            font-size: 0.9rem;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .card-text {
            margin-bottom: 0.3rem;
        }

        .navbar-brand img {
            height: 30px;
        }

        footer {
            background-color: #9dabb9;
            padding: 40px 0;
        }

        .footer-logo img {
            height: 40px;
        }


        @media (max-width: 767.98px) {
            .profile-header {
                text-align: center;
            }

            .profile-image {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<!-- Navbar -->
@extends('layouts.app')

@section('content')

    <body class="d-flex flex-column min-vh-100">

        {{-- USER LISTING  --}}
        <div class="container mt-2">
            <h2 class="p-2 fw-bold">{{ $user->name }}'s Listings</h2>

            <div class="profile-header">
                <div class="row align-items-start">
                    <div class="mb-3 text-center col-md-auto mb-md-0 text-md-start">
                        <img src="{{ $user->profile_photo_url }}" alt="Profile Picture"
                            class="mx-auto profile-image mx-md-0 d-block">
                    </div>
                    <div class="col-md">
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <div>
                                <h3 class="mb-1 text-center text-md-start">{{ $user->name }}</h3>
                                <p class="mb-2 text-center text-md-start">
                                    <i class="fas fa-map-marker-alt" style="color: blue;"></i> {{ $user->userAddress }}
                                </p>
                                <p class="mb-2 text-center text-md-start">
                                    <i class="fas fa-envelope" style="color: blue;"></i> {{ $user->email }}
                                </p>
                            </div>
                            @if (Auth::check() && Auth::id() === $user->id)
                                <div class="mt-2 mt-md-0">
                                    <a href="{{ route('profile.show') }}" class="btn btn-primary btn-sm me-2">
                                        <i class="fas fa-user-edit"></i> Edit Profile
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <ul class="mb-3 nav nav-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="items-tab" data-bs-toggle="tab" data-bs-target="#items"
                        type="button" role="tab" aria-controls="items" aria-selected="true">Items for sale
                        ({{ $totalProducts }})</button>
                    {{-- <!-- In Laravel, use: Items for sale ({{ $userProducts->product->count() }}) --> --}}
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                        role="tab" aria-controls="reviews" aria-selected="false">Reviews (0)</button>
                    {{-- <!-- In Laravel, use: Reviews ({{ $user->reviews->count() }}) --> --}}
                </li>
            </ul>

            <div class="tab-content" id="profileTabsContent">
                <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">
                    @if ($totalProducts > 0)
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                            @foreach ($userProducts as $product)
                                <div class="col">
                                    <div class="card h-100">
                                        <a href="/marketplace/product/{{ $product->id }}">
                                            <img src="{{ asset('storage/' . $product->prodImage) }}"
                                                class="card-img-top item-image" alt="{{ $product->prodName }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->prodName }}</h5>
                                                <p class="card-text">₱{{ $product->prodPrice }}</p>
                                                <p class="card-text"><small
                                                        class="text-muted">{{ $product->author->userAddress }}</small></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <p>No products are currently listed.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                {{-- <!-- In Laravel, use:
                @if ($user->reviews->count() > 0)
                    @foreach ($user->reviews as $review)
                    <div class="mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->title }}</h5>
                            <p class="card-text">{{ $review->content }}</p>
                            <p class="card-text"><small class="text-muted">By {{ $review->reviewer->name }} on {{ $review->created_at->format('M d, Y') }}</small></p>
                        </div>
                    </div>
                    @endforeach
                @else
                --> --}}
                <p class="p-5 text-center">No reviews yet.</p>
                {{-- <!-- @endif --> --}}
            </div>
        </div>
        </div>

        {{-- FOOTER --}}
        {{-- <footer class="mt-auto">
            <div class="container">
                <div class="row">
                    <div class="mb-4 col-md-4 mb-md-0">
                        <div class="mb-3 footer-logo">
                            <img src="" alt="ThriftyTrade Logo">
                        </div>
                        <p>Your gateway to easier thrifting, buying, and selling locally.</p>
                    </div>
                    <div class="mb-4 col-md-2 mb-md-0">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none">Home</a></li>
                            <li><a href="#" class="text-decoration-none">MarketPlace</a></li>
                            <li><a href="#" class="text-decoration-none">Sell</a></li>
                        </ul>
                    </div>
                    <div class="mb-4 col-md-2 mb-md-0">
                        <h5>Support</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none">Terms of Service</a></li>
                            <li><a href="#" class="text-decoration-none">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Connect With Us</h5>
                        <div class="d-flex">
                            <a href="#" class="me-3 text-decoration-none"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="me-3 text-decoration-none"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="me-3 text-decoration-none"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-decoration-none"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <div class="mt-3">
                        </div>
                    </div>
                </div>
                <hr>

            </div>
        </footer> --}}
    @endsection
</body>

</html>
