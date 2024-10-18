@extends('layouts.app')

@section('content')
    <x-products.detail-content :marketplaceProducts="$marketplaceProducts" />
@endsection

{{-- DESIGN IS STILL NOT RESPONSIVE --}}
{{-- ESPLECIALLY THE DETAILS --}}
{{-- NEED TO WORK ON RESPONSIVE DESIGN --}}

{{--  --}}
