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
        object-fit: cover;
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

    /* overflow: -moz-scrollbars-none;
     */
</style>


@extends('layouts.app')

@section('content')
    @include('components.hero-section')
    {{-- SIDE-BAR --}}


    <div class="container mt-4">

        @guest
            @include('layouts.side-bar.side-bar-guest')
        @endguest


        @auth
            @include('layouts.side-bar.side-bar-auth')
        @endauth


        @include('components.partials.product-card')
         <!-- CONTENT -->
        <div class="col-lg-9">
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
        </main>

    </div>

        <!-- END OF CONTENT -->

    </div>


    @include('components.howitworks')
</div>
@endsection
