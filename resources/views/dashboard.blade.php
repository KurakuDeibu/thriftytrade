<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #4267b2 !important;
        }

        .fixed-image {
            width: 100%;
            height: 10rem;
            object-fit: fill;
            border-radius: 0;
        }

        .sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            position: relative;
        }

        .badge-container {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 1.05em;
        }

        .badge {
            transition: transform 0.5s ease, opacity 0.3s ease;
            position: relative;
            opacity: 0.80;
        }

        .badge:hover {
            transform: scale(1.4);
            opacity: 1;
        }

        .icon-large {
            font-size: 1.2rem;
        }

        .badge-text {
            display: none;
            position: absolute;
            bottom: 10px;
            left: -20px;
            transform: translateX(-50%);
            font-size: 0.8rem;
            color: #ffffff;
            background-color: rgba(110, 141, 185, 0.7);
            padding: 2px 5px;
            white-space: nowrap;
            border-radius: 3px;
        }

        .badge:hover .badge-text {
            display: block;
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
                        @endif
                    </div>

                </main>
            </div>
            {{-- END OF DASHBOARD --}}

        </div>
    </div>
    <!-- END OF CONTENT -->
    {{-- @include('components.pagination') --}}
@endsection
