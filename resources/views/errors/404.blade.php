<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

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


<div class="container">
    <div class="error-container">
        <i class="mb-4 bi bi-exclamation-triangle error-icon"></i>
        <h1 class="mb-4 display-4">Oops! Page Not Found</h1>
        <p class="mb-4 lead">We couldn't find the page you're looking for. It might have been removed, renamed, or
            doesn't exist.</p>`
        <a href="javascript:history.back()" class="btn btn-primary btn-lg">
            <i class="bi bi-back me-2"></i> Return back
        </a>
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-shop me-2"></i> Return Home
        </a>
    </div>
</div>
