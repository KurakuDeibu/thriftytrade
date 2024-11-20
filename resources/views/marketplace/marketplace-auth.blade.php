<style>
    .hero-section {
        background: linear-gradient(rgba(11, 66, 177, 0.8), rgba(66, 103, 178, 0.9)), url('img/hero-img.png');
        background-size: cover;
        padding: 60px 0;
        margin-bottom: 15px;
    }

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
    <div class="container mt-2">
        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                    <li class="breadcrumb-item active"><small><a href="{{ url('marketplace') }}">Marketplace</a></small></li>
                    </li>
                </ol>
            </nav>
            @auth
                @include('layouts.side-bar.side-bar-auth')
            @endauth

            @guest
                @include('layouts.side-bar.side-bar-guest')
            @endguest

            {{-- @include('components.search-bar') --}}

            {{-- SEARCH - INCLUDES PAGINATION&FILTERS --}}
            @livewire('search-products', [
                'category' => request('category'),
                'condition' => request('condition'),
                'featured' => request('featured'),
                'sort' => request('sort'),
                'search' => request('query'),
            ])
            <!-- Hidden inputs for preserving current filters -->
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            @if (request('condition'))
                <input type="hidden" name="condition" value="{{ request('condition') }}">
            @endif

            @if (request('featured'))
                <input type="hidden" name="featured" value="{{ request('featured') }}">
            @endif

            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif


            <!-- END OF CONTENT -->
        </div>

        {{-- APPENDS ALL THE FILTERS WITH THE PAGINATION --}}
        {{-- PAGINATION --}}
        {{-- {{ $marketplaceProducts->appends([
                'query' => request('query'),
                'category' => request('category'),
                'condition' => request('condition'),
                'featured' => request('featured'),
                'sort' => request('sort'),
                'location' => request('location'),
                'price_type' => request('price_type'),
            ])->links() }} --}}
    </div>
    </div>
    @include('layouts.partials.footer-top')
@endsection

<style>
    .badge a:hover {
        opacity: 0.7;
    }
</style>
