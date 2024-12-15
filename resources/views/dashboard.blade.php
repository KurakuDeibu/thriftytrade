<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #4267b2 !important;
        }

        .sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-text {
            padding-left: 18px;
            border-left: 3px solid #477CDB
        }
    </style>
</head>
@extends('layouts.app')
@section('content')
    <div class="container mt-2">

        <div class="row">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                    <li class="breadcrumb-item"><small><a href="{{ route('marketplace') }}">Marketplace</a></small></li>
                    <li class="breadcrumb-item active"><small>Dashboard</small></li>
                </ol>
            </nav>
            @auth
                @include('layouts.side-bar.side-bar-auth')
            @else
                @include('layouts.side-bar.side-bar-guest')
            @endauth

            {{-- @include('components.search-bar') --}}
            <!-- SIDE-BAR CONTAINER-->

            <div class="py-2 border-2 border-white col-lg-9">
                <!-- CONTENT -->
                <main>
                    <!-- CONTENT -->
                    <div class="container mt-4">
                        @if (Route::currentRouteName() === 'dashboard')
                            @include('dashboard-content')
                        @elseif (Route::currentRouteName() === 'manage-listing')
                            @include('components.products.manage-listings')
                        @elseif (Route::currentRouteName() === 'seller-offers')
                            @include('seller.offers.index')
                        @elseif (Route::currentRouteName() === 'user.transactions')
                            @include('transactions.index')
                        @endif
                    </div>

                </main>
            </div>
            {{-- END OF DASHBOARD --}}

        </div>
    </div>
    <!-- END OF CONTENT -->
    {{-- @include('components.pagination') --}}
    </div>
    @include('layouts.partials.footer-top')
@endsection
