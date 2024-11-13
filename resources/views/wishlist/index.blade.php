@extends('layouts.app')

@section('content')
    <div class="py-4 container-fluid bg-light">
        <div class="container">
            <div class="mb-4 row align-items-center">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h1 class="text-indigo-600 h2 fw-bold">Your Wishlists</h1>
                    <a href="{{ route('marketplace') }}" class="btn btn-outline-indigo d-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span class="d-none d-sm-inline">Find More</span>
                    </a>
                </div>
            </div>

            @if ($wishlists->isEmpty())
                <div class="py-5 text-center row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <i class="mb-4 text-indigo-300 bi bi-heart display-4"></i>
                        <h2 class="mb-3 text-gray-600 h3">Your Wishlist is Empty</h2>
                        <p class="mb-4 text-muted">
                            Discover amazing products and add them to your wishlist. Your favorite items are just a click
                            away!
                        </p>
                        <a href="{{ route('marketplace') }}" class="btn btn-outline-primary">
                            Explore Marketplace
                        </a>
                    </div>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($wishlists as $wishlist)
                        <div class="col">
                            <div class="overflow-hidden transition shadow-sm card h-100 position-relative hover:shadow">
                                <div class="gap-2 position-absolute top-2 end-2 d-flex">
                                    <span class="text-indigo-600 badge bg-indigo-50 rounded-pill">
                                        {{ $wishlist->product->category->categName }}
                                    </span>
                                    @if ($wishlist->product->status)
                                        <span class="badge bg-success-50 text-success-600 rounded-pill">
                                            {{ $wishlist->product->status->statusName }}
                                        </span>
                                    @endif
                                </div>

                                <img src="{{ $wishlist->product->prodImage ? asset('storage/' . $wishlist->product->prodImage) : asset('img/NOIMG.jpg') }}"
                                    class="card-img-top object-fit-cover" style="height: 200px;">

                                <div class="card-body">
                                    <div class="mb-3 d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="card-title text-truncate" style="max-width: 250px;">
                                                {{ $wishlist->product->prodName }}
                                            </h5>
                                            <a href="{{ route('profile.user-listing', $wishlist->product->author->id) }}">
                                                <p class="text-muted small">
                                                    by {{ $wishlist->product->author->name }}
                                                </p>
                                            </a>
                                        </div>
                                        <div class="text-indigo-600 fw-bold">
                                            ${{ number_format($wishlist->product->prodPrice, 2) }}
                                        </div>
                                    </div>

                                    <div class="pt-3 d-flex justify-content-between border-top">
                                        <a href="/marketplace/product/{{ $wishlist->product->id }}"
                                            class="text-indigo-500 text-decoration-none d-flex align-items-center">
                                            <i class="bi bi-eye me-2"></i>
                                            View Details
                                        </a>

                                        <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-0 btn btn-link text-danger d-flex align-items-center">
                                                <i class="bi bi-heart-fill me-2"></i>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-indigo-50 {
            background-color: #e0e7ff !important;
        }

        .text-indigo-600 {
            color: #4f46e5 !important;
        }

        .bg-success-50 {
            background-color: #dcfce7 !important;
        }

        .text-success-600 {
            color: #16a34a !important;
        }

        .transition {
            transition: all 0.3s ease;
        }

        .hover\:shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
