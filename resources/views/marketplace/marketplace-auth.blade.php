<style>
    .sidebar {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }

    .dashboard-btn {
        background-color: #4267B2;
        color: white;
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
</style>




@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">

            @auth
                @include('layouts.side-bar.side-bar-auth')
            @endauth

            @guest
                @include('layouts.side-bar.side-bar-guest')
            @endguest

            @include('components.search-bar')
            <!-- SIDE-BAR CONTAINER-->

            <!-- CONTENT -->
            <main>
                <div class="py-2 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    @foreach ($marketplaceProducts as $products)
                        <x-products.content-card :products="$products" />
                    @endforeach

                    @if (!$marketplaceProducts->hasMorePages())
                        <div class="text-center alert alert-primary w-100">No more products to show...</div>
                    @endif

                </div>
        </div>
        </main>
        <!-- END OF CONTENT -->
        {{-- @include('components.pagination') --}}
    </div>

    </div>
    {{ $marketplaceProducts->appends(['query' => $query])->links() }}
    </div>
@endsection
