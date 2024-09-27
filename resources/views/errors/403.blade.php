<style>
    .navbar-brand {
        font-weight: bold;
        color: #0d6efd !important;
    }

    .error-container {
        max-width: 800px;
        margin: 100px auto;
        text-align: center;
        background-color: #f7f7f7;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .error-icon {
        font-size: 8rem;
        color: #002aff;
    }

    .btn-primary {
        background-color: #ff9900;
        border-color: #ff9900;
    }

    .btn-primary:hover {
        background-color: #ffc107;
        border-color: #ffc107;
    }
</style>

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="error-container">
        <i class="mb-4 bi bi-lock-fill error-icon"></i>
        <h1 class="mb-4 display-4">Access Denied</h1>
        <p class="mb-4 lead">You don't have permission to access this page. Please contact the administrator if you think this is an error.</p>
        <a href="/" class="btn btn-primary btn-lg">
            <i class="bi bi-arrow-left me-2"></i>Return to Home
        </a>
    </div>
</div>
@endsection
