@extends('layouts.app')

@if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@section('content')
    <x-products.detail-content :marketplaceProducts="$marketplaceProducts" :showOtherListings="$showOtherListings" :hasOtherListings="$hasOtherListings" :similarListings="$similarListings" />

    @include('layouts.partials.footer-top')
@endsection

{{-- DESIGN IS STILL NOT RESPONSIVE --}}
{{-- ESPLECIALLY THE DETAILS --}}
{{-- NEED TO WORK ON RESPONSIVE DESIGN --}}

{{--  --}}
