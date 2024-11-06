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
</style>


@extends('layouts.app')


{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

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
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-2"><strong>Featured Products</strong></h2>
                    <a href="" class="mb-2 text-primary badge"><strong>View All
                            ></strong></a>
                </div>
                <div class="mb-4 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    @foreach ($featuredProducts as $products)
                        <x-products.content-card :products="$products" />
                    @endforeach

                </div>
                <a class="block text-lg text-center" href="{{ route('marketplace') }}">
                    <div class="btn btn-outline-primary">View More</div>
                </a>

            </main>
        </div>
        {{-- @include('components.partials.product-card') --}}
        {{-- THE CODE ON TOP IS NOT NEEDED ANYMORE --}}


        <!-- CONTENT -->
        {{-- <div class="col-lg-9">
            <main>
                <h2 class="mb-4">Featured Items</h2>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <div class="col">
                        @foreach ($featuredProducts as $products)
                            <div class="card h-100 item-card">
                                <img src="https://placehold.co/600x400" alt="Vintage Lamp" class="card-img-top item-image">
                                <div class="card-body">
                                    <a href="/product" class="card-title item-title">$</a>
                                    <p class="card-text item-price">$45</p>
                                    @guest
                                        <a href="/login" class="btn btn-outline-primary btn-sm">Login to View</a>
                                    @endguest

                                </div>
                        @endforeach

                    </div>
                </div>
        </div>
        </main> --}}

    </div>

    <!-- END OF CONTENT -->

    </div>


    @include('components.howitworks')
    </div>
@endsection

<script>
    const scrollContainer = document.querySelector('.scroll-categories');

    let isDown = false;
    let startX;
    let scrollLeft;

    scrollContainer.addEventListener('mousedown', (e) => {
        isDown = true;
        scrollContainer.classList.add('active');
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
    });

    scrollContainer.addEventListener('mouseleave', () => {
        isDown = false;
        scrollContainer.classList.remove('active');
    });

    scrollContainer.addEventListener('mouseup', () => {
        isDown = false;
        scrollContainer.classList.remove('active');
    });

    scrollContainer.addEventListener('mousemove', (e) => {
        if (!isDown) return; // Stop the fn from running
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 2; // The multiplier controls the scroll speed
        scrollContainer.scrollLeft = scrollLeft - walk;
    });
</script>
