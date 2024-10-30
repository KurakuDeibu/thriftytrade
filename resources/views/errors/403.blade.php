<style>
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
</style>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="error-container">
            <i class="mb-4 bi bi-lock error-icon"></i>
            <h1 class="mb-4 display-4">Access Denied</h1>
            <p class="mb-4 lead">You don't have permission to access this page.</p>
            <a href="/" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-left me-2"></i>Return to Home
            </a>
        </div>
    </div>
@endsection
