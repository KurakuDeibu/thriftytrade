<style>
    .navbar-brand {
        font-weight: bold;
        color: #0d6efd !important;
    }

    .error-container {
        max-width: 600px;
        margin: 100px auto;
        text-align: center;
    }

    .error-icon {
        font-size: 6rem;
        color: #0d6efd;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
    }
</style>


@extends('layouts.app')

@section('content')

<div class="container">
    <div class="error-container">
        <i class="mb-4 bi bi-exclamation-triangle error-icon"></i>
        <h1 class="mb-4 display-4">Oops! Page Not Found</h1>
        <p class="mb-4 lead">We couldn't find the page you're looking for. It might have been removed, renamed, or doesn't exist.</p>
        <a href="/" class="btn btn-primary btn-lg">
            <i class="bi bi-shop me-2"></i>Return to Home
        </a>
    </div>
</div>
@endsection


