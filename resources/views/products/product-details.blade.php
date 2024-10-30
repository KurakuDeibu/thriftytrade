@extends('layouts.app')


@section('content')
    <x-products.detail-content :marketplaceProducts="$marketplaceProducts" :showOtherListings="$showOtherListings" :hasOtherListings="$hasOtherListings" />
@endsection

{{-- DESIGN IS STILL NOT RESPONSIVE --}}
{{-- ESPLECIALLY THE DETAILS --}}
{{-- NEED TO WORK ON RESPONSIVE DESIGN --}}

{{--  --}}
