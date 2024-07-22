<style>
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
    </style>
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
            @include('components.contents')

            @include('components.howitworks')
    </div>

@endsection
