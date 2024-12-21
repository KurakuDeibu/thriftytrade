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
                                    <span class="badge bg-success" title="Verified User">
                                        <i class="bi bi-check-circle"></i>
                                    </span>
                                @else
                                    <span class="badge bg-danger" title="Unverified User">
                                        <i class="bi bi-x-circle"></i>
                                    </span>
                                @endif

                                {{-- FINDER BADGE --}}
                                @if ($user->finder_status == 'approved' || $user->isFinder == true)
                                    <span class="rounded-md badge bg-primary ms-2 d-flex align-items-center"
                                        title="Verified Finder">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="handshake"
                                            class="svg-inline--fa fa-handshake" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                            style="width: 0.8rem; height: 0.8rem;">
                                            <path fill="currentColor"
                                                d="M323.4 85.2l-96.8 78.4c-16.1 13-19.2 36.4-7 53.1c12.9 17.8 38 21.3 55.3 7.8l99.3-77.2c7-5.4 17-4.2 22.5 2.8s4.2 17-2.8 22.5l-20.9 16.2L512 316.8V128h-.7l-3.9-2.5L434.8 79c-15.3-9.8-33.2-15-51.4-15c-21.8 0-43 7.5-60 21.2zm22.8 124.4l-51.7 40.2C263 274.4 217.3 268 193.7 235.6c-22.2-30.5-16.6-73.1 12.7-96.8l83.2-67.3c-11.6-4.9-24.1-7.4-36.8-7.4C234 64 215.7 69.6 200 80l-72 48V352h28.2l91.4 83.4c19.6 17.9 49.9 16.5 67.8-3.1c5.5-6.1 9.2-13.2 11.1-20.6l17 15.6c19.5 17.9 49.9 16.6 67.8-2.9c4.5-4.9 7.8-10.6 9.9-16.5c19.4 13 45.8 10.3 62.1-7.5c17.9-19.5 16.6-49.9-2.9-67.8l-134.2-123zM16 128c-8.8 0-16 7.2-16 16V352c0 17.7 14.3 32 32 32H64c17.7 0 32-14.3 32-32V128H16zM48 320a16 16 0 1 1 0 32 16 16 0 1 1 0-32zM544 128V352c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V144c0-8.8-7.2-16-16-16H544zm32 208a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z">
                                            </path>
                                        </svg>
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
    </body>
@endsection

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
