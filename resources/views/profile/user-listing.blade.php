<title>{{ $user->name }}'s Listings</title>
<style>
    .profile-header {
        background-color: #e6e7e85b;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 20px;
    }

    .profile-header img {
        border: 3px solid #f8f9fa;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }

    .item-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
    }

    .card {
        font-size: 0.9rem;
        transition: transform 0.2s;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .card-text {
        margin-bottom: 0.3rem;
    }

    .navbar-brand img {
        height: 30px;
    }

    footer {
        background-color: #9dabb9;
        padding: 40px 0;
    }

    .footer-logo img {
        height: 40px;
    }


    @media (max-width: 576px) {
        .profile-image {
            margin-bottom: 1rem;
        }
    }
</style>

<!-- Navbar -->
@extends('layouts.app')

@section('content')

    <body class="d-flex flex-column min-vh-100">

        {{-- USER PUBLIC-PROFILE INFO  --}}
        <div class="container mt-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                    <li class="breadcrumb-item"><small><a href="{{ route('marketplace') }}">Marketplace</a></small></li>
                    <li class="breadcrumb-item active"><small>{{ $user->name }}'s' Listings</small>
                    </li>
                </ol>
            </nav>

            <div class="container mt-4">
                <div class="p-4 bg-white shadow-sm profile-header rounded-4">
                    <div class="row align-items-center">
                        <div class="text-center col-md-3">
                            <img src="{{ $user->profile_photo_url }}" alt="Profile Picture" class="mb-3 rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="mb-2 d-flex align-items-center">
                                <h2 class="mb-0 me-2">{{ $user->name }}</h2>
                                @if ($user->hasVerifiedEmail())
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Verified
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Unverified
                                    </span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <div class="text-muted">
                                    <i class="bi bi-calendar-check me-2"></i>
                                    Joined {{ $user->created_at->diffForHumans() }}
                                </div>

                                <div class="text-muted">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    {{ $user->userAddress }}
                                </div>

                                @auth

                                    <div class="text-muted">
                                        <i class="bi bi-envelope me-2"></i>
                                        {{ $user->email }}
                                    </div>

                                    <div class="text-muted">
                                        <i class="bi bi-telephone-forward me-2"></i>
                                        <span id="phoneNumberDisplay">
                                            @if ($user->phoneNum)
                                                <span id="partialPhoneNumber">
                                                    {{ substr($user->phoneNum, 0, 4) }}****
                                                </span>
                                                <span id="fullPhoneNumber" class="d-none text-primary">
                                                    {{ $user->phoneNum }}
                                                </span>
                                                <button id="revealPhoneBtn" class="py-0 text-sm btn btn-link btn-sm">
                                                    (click-to-reveal)
                                                </button>
                                            @else
                                                Not provided
                                            @endif
                                        </span>
                                    </div>
                                @endauth

                            </div>

                            <div class="gap-2 ">
                                @if (Auth::check() && Auth::id() === $user->id)
                                    <a href="{{ route('profile.show') }}"> <button
                                            class="px-4 py-2 text-sm btn btn-outline-primary">
                                            <i class="bi bi-pencil me-1"></i>Edit Profile</button></a>
                                    <a href="{{ route('dashboard') }}"> <button
                                            class="px-4 py-2 text-sm btn btn-outline-info">
                                            <i class="bi bi-speedometer2 me-1"></i>My Dashboard</button></a>
                                @else
                                    @auth
                                        <button class="px-4 py-2 text-sm btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#reportModal">
                                            <i class="fas fa-flag"></i> Report
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="px-4 py-2 text-sm report-icon btn btn-outline-danger" title="Report Product">
                                            <i class="fas fa-flag"></i> Report
                                        </a>
                                    @endauth
                                @endif

                                <!-- Report modal -->
                                @include('components.products.report-listing-form')

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="mb-3 nav nav-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="items-tab" data-bs-toggle="tab" data-bs-target="#items"
                        type="button" role="tab" aria-controls="items" aria-selected="true">Items for sale
                        ({{ $userProductsCount }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                        role="tab" aria-controls="reviews" aria-selected="false">Reviews
                        ({{ $userReviewsCount }})</button>
                </li>
            </ul>

            {{-- USER LISTING TABS  --}}
            <div class="tab-content" id="profileTabsContent">
                <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">
                    @if (count($userProducts) > 0)
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                            @foreach ($userProducts as $product)
                                <div class="col">
                                    <div class="card h-100">
                                        <a href="/marketplace/product/{{ $product->id }}">
                                            <img src="{{ $product->prodImage && file_exists(public_path('storage/' . $product->prodImage))
                                                ? asset('storage/' . $product->prodImage)
                                                : asset('img/NOIMG.jpg') }}"
                                                class="card-img-top item-image" alt="{{ $product->prodName }}">
                                            <!-- Status and Condition Icons -->
                                            <div class="top-0 p-2 position-absolute start-0">
                                                <div class="d-flex flex-column">
                                                    <!-- Condition Icon -->
                                                    <span
                                                        class="badge bg-{{ $product->prodCondition == 'New'
                                                            ? 'success'
                                                            : ($product->prodCondition == 'Likely-New'
                                                                ? 'success'
                                                                : ($product->prodCondition == 'Used'
                                                                    ? 'success'
                                                                    : ($product->prodCondition == 'Likely-Used'
                                                                        ? 'success'
                                                                        : 'secondary'))) }} mb-1"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ ucfirst($product->prodCondition) }}">
                                                        {{ ucfirst($product->prodCondition) }}
                                                    </span>

                                                    <!-- Status Icon -->
                                                    <span
                                                        class="badge
                                                        {{ $product->status == 'Available'
                                                            ? 'bg-success'
                                                            : ($product->status == 'Pending'
                                                                ? 'bg-warning'
                                                                : ($product->status == 'Sold'
                                                                    ? 'bg-secondary'
                                                                    : 'bg-info')) }}"
                                                        data-bs-toggle="tooltip" title="{{ ucfirst($product->status) }}">
                                                        @switch($product->status)
                                                            @case('Available')
                                                                <i class="bi bi-check-circle me-1"></i>
                                                            @break

                                                            @case('Pending')
                                                                <i class="bi bi-hourglass-split me-1"></i>
                                                            @break

                                                            @case('Sold')
                                                                <i class="bi bi-bag-x me-1"></i>
                                                            @break

                                                            @default
                                                                <i class="bi bi-question-circle me-1"></i>
                                                        @endswitch
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->prodName }}</h5>
                                                <p class="card-text">₱{{ $product->prodPrice }}</p>
                                                <p class="card-text"><small
                                                        class="text-muted">{{ $product->author->userAddress }}</small></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $userProducts->links() }}
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <p>No products are currently listed.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- USER REVIEWS TABS --}}
            <div class="tab-content" id="profileTabsContent">
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    @if ($userReviewsCount > 0)
                        <div class="row">

                            {{-- Overall Rating Summary --}}
                            <div class="mb-4 col-md-4">
                                <div class="card">
                                    <div class="text-center card-body">
                                        <h4>Overall Rating</h4>
                                        <div class="display-4 text-warning">
                                            {{ number_format($averageRating, 1) }}
                                            <small class="text-muted">/5</small>
                                        </div>
                                        <div class="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bi bi-star{{ $i <= round($averageRating) ? '-fill text-warning' : ' text-muted' }}"></i>
                                            @endfor
                                        </div>
                                        <small class="text-muted">
                                            Based on {{ $userReviewsCount }}
                                            {{ Str::plural('review', $userReviewsCount) }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Reviews List --}}
                            <div class="col-md-8">
                                @foreach ($userReviews as $review)
                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                {{-- Reviewer Profile Image --}}
                                                <img src="{{ $review->reviewer->profile_photo_url }}"
                                                    class="rounded-circle me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">

                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <a
                                                                    href="{{ route('profile.user-listing', $review->reviewer->id) }}">
                                                                    {{ $review->reviewer->name ?? 'Anonymous' }}
                                                                    <span class="badge bg-secondary ms-2">
                                                                        {{ $review->role ?? 'Unknown' }}
                                                                    </span>
                                                                </a>
                                                            </h6>
                                                            <small class="text-muted">
                                                                {{ $review->created_at->diffForHumans() }}
                                                            </small>
                                                        </div>

                                                        {{-- Rating Stars --}}
                                                        <div class="rating-stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    {{-- Reviewed Product --}}
                                                    <div class="mt-2 mb-2 d-flex align-items-center">
                                                        <img src="{{ $review->product->prodImage ? asset('storage/' . $review->product->prodImage) : asset('img/NOIMG.jpg') }}"
                                                            class="rounded me-2"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                        <small class="text-muted">
                                                            Listing Name: <span
                                                                class="fw-bold">{{ $review->product->prodName }}</span>
                                                        </small>
                                                    </div> {{-- Review Content --}}
                                                    <div class="p-2 rounded review-content bg-light">
                                                        <p class="mb-0">
                                                            <i class="bi bi-quote me-1"></i>
                                                            {{ $review->content }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="p-5 text-center">No reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>

        @include('layouts.partials.footer-top')

    @endsection
</body>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealPhoneBtn = document.getElementById('revealPhoneBtn');
            const partialPhoneNumber = document.getElementById('partialPhoneNumber');
            const fullPhoneNumber = document.getElementById('fullPhoneNumber');

            if (revealPhoneBtn) {
                revealPhoneBtn.addEventListener('click', function() {
                    if (partialPhoneNumber.classList.contains('d-none')) {
                        // Currently showing full number, switch back to partial
                        partialPhoneNumber.classList.remove('d-none');
                        fullPhoneNumber.classList.add('d-none');
                        revealPhoneBtn.textContent = '(click-to-reveal)';
                    } else {
                        // Currently showing partial number, switch to full
                        partialPhoneNumber.classList.add('d-none');
                        fullPhoneNumber.classList.remove('d-none');
                        revealPhoneBtn.textContent = 'Hide';
                    }
                });
            }

            fullPhoneNumber.addEventListener('click', function() {
                const phoneNumber = this.textContent.trim();
                window.location.href = 'tel:' + phoneNumber;
            });
            fullPhoneNumber.style.cursor = 'pointer';
        });
    </script>
@endpush
