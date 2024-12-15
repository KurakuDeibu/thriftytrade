<style>
    .navbar-brand {
        font-weight: bold;
        color: #4267B2 !important;
    }

    .btn-new-listing {
        background-color: #42b72a;
        color: white;
    }

    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        object-fit: inherit;
    }

    .item-title {
        font-weight: bold;
    }

    .item-price {
        color: #4267B2;
        font-weight: 500;
    }

    .auth-prompt {
        background-color: #e9ecef;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .hero-section {
        background: linear-gradient(rgba(11, 66, 177, 0.8), rgba(66, 103, 178, 0.9)), url('img/hero-img.png');
        background-size: cover;
        color: white;
        padding: 60px 0;
        margin-bottom: 15px;
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scroll-container {
        scroll-behavior: smooth;
    }

    .scroll-categories {
        overflow-x: auto;
        white-space: nowrap;
        /* Prevent wrapping */
    }

    .scroll-categories::-webkit-scrollbar {
        display: none;
        /* Hide the scrollbar */
    }

    .scroll-categories {
        -ms-overflow-style: none;
        scrollbar-width: none;
        overflow: -moz-scrollbars-none;
    }

    .section-text {
        padding-left: 18px;
        border-left: 3px solid #477CDB
    }
</style>


@extends('layouts.app')

@section('content')
    @include('components.hero-section')
    {{-- SIDE-BAR --}}


    {{-- SHOW ALL CATEGORIES WITH IMAGE --}}


    <div class="container mt-4">

        @guest
            @include('layouts.side-bar.side-bar-guest')
        @endguest


        @auth
            @include('layouts.side-bar.side-bar-auth')
        @endauth

        <div class="col-lg-9">
            <main>
                <div class="flex items-center justify-between mb-1">
                    <div class="section-text">
                        <h2 class="text-lg text-indigo-500 fw-bold">FEATURED PRODUCTS</h2>
                        <p class="text-sm text-muted">Available featured products</p>
                    </div>
                    <a href="{{ route('marketplace', ['featured' => true]) }}" class="btn btn-outline-primary"> <i
                            class="fas fa-search me-2"></i>View All</a>
                </div>

                <div class="mt-1 mb-4 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    @foreach ($featuredProducts as $products)
                        <x-products.content-card :products="$products" />
                    @endforeach

                </div>
            </main>
        </div>
        {{-- @include('components.partials.product-card') --}}
        {{-- THE CODE ON TOP IS NOT NEEDED ANYMORE --}}

    </div>

    <!-- END OF CONTENT -->

    </div>

    `
    @include('marketplace.view-finders')

    @include('components.howitworks')

    </div>
    @include('layouts.partials.footer-top')
@endsection
