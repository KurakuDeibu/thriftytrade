<div class="container-fluid marketplace-listings">
    <div
        class="px-2 py-2 mb-4 d-flex justify-content-between align-items-center bg-gradient-to-br from-gray-100 to-indigo-100">
        <div class="section-text">
            <h1 class="text-xl navbar-brand">MY COMMISSION HISTORY</h1>
            <h1 class="text-sm text-muted">View your commission history</h1>
        </div>
    </div>

    <ul class="mb-3 nav nav-tabs" id="transactionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="finder-transaction-tab" data-bs-toggle="tab"
                data-bs-target="#finder-transaction" type="button" role="tab" aria-controls="finder-transaction"
                aria-selected="false">
                As a Finder ( {{ $transactionsfinder->count() }})
            </button>
        </li>

    </ul>

    <div class="tab-content" id="transactionTabsContent">

        {{-- TRANSACTION TAB FOR FINDERS --}}
        <div class="tab-pane fade show active" id="finder-transaction" role="tabpanel"
            aria-labelledby="finder-transaction-tab">
            @if ($transactionsfinder->isEmpty())
                <div class="mb-4">
                    <div class="p-4 text-center bg-white rounded shadow-sm stat-card-custom">
                        <div class="p-3 mx-auto mb-3">
                            <i class="fas fa-inbox text-secondary fa-3x"></i>
                        </div>
                        <h5 class="mb-2 text-muted">You have empty transactions at the moment.</h5>
                    </div>
                </div>
            @else
                <div class="row row-cols-1 g-4">
                    @foreach ($transactionsfinder as $transaction)
                        <div class="col-lg-12">
                            <div class="card listing-card position-relative border-primary">
                                <div class="row g-0">
                                    <!-- Product Image -->
                                    <div class="col-md-4 position-relative">
                                        <div class="h-100 listing-image-container" style="height: 250px; width: 100%;">
                                            <img src="{{ $transaction->product->prodImage && file_exists(public_path('storage/' . $transaction->product->prodImage))
                                                ? asset('storage/' . $transaction->product->prodImage)
                                                : asset('img/NOIMG.jpg') }}"
                                                class="border-2 card-img-top listing-image w-100 h-100 object-fit-cover"
                                                style="max-height: 250px; min-height: 250px; object-fit: cover;"
                                                alt="{{ $transaction->product->prodName }}">
                                        </div>
                                    </div>

                                    <!-- Transaction Details -->
                                    <div class="col-md-8 position-relative">
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2 d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h1>Commission Listing Details</h1>
                                                    <h5 class="mb-1 card-title"><a
                                                            href="{{ route('product', $transaction->product->id) }}">
                                                            {{ Str::limit($transaction->product->prodName, 50) }}</a>
                                                    </h5>
                                                    <p class="mb-0 text-muted small">
                                                        Listed by: {{ $transaction->offer->product->user->name }} <br>
                                                        •
                                                        {{ $transaction->updated_at->format('M d, Y') }} @
                                                        {{ $transaction->updated_at->format('h:i A') }}
                                                    </p>
                                                </div>


                                                <!-- Transaction Actions -->
                                                <div class="mb-1 text-primary h4">
                                                    Finder's Fee
                                                    :₱{{ number_format($transaction->offer->offered_finders_fee, 2) }}
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="mt-2 mb-2 row">
                                                <div class="col-md-12">
                                                    <div class="mb-1 text-sm text-muted">
                                                        User Budget Price:
                                                        ₱{{ number_format($transaction->product->prodPrice, 2) }}
                                                    </div>
                                                    <div class="mb-1 text-sm text-muted">
                                                        You accepted {{ $transaction->user->name }} offer:
                                                        ₱{{ number_format($transaction->offer_price, 2) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="inline-flex gap-2 mt-2 d-flex">
                                                <button wire:click="viewOfferDetails({{ $transaction->id }})"
                                                    class="btn btn-outline-primary w-50" data-bs-toggle="modal"
                                                    data-bs-target="#transactionModal">
                                                    <i class="bi bi-eye me-1"></i> View Transaction
                                                </button>

                                                @php
                                                    $selectedOffer = $transaction;
                                                @endphp

                                                @include('transactions.transaction-modal')

                                                @php
                                                    $hasReviewed = $transaction->offer->hasBeenReviewedByUser(
                                                        auth()->id(),
                                                    );
                                                @endphp

                                                @if ($hasReviewed)
                                                    <button class="btn btn-outline-success w-50" disabled>
                                                        <i class="bi bi-check-circle me-1"></i> Reviewed
                                                    </button>
                                                @else
                                                    <button class="btn btn-outline-warning w-50" data-bs-toggle="modal"
                                                        data-bs-target="#reviewModal{{ $transaction->id }}"
                                                        title="Add Review">
                                                        <i class="bi bi-star-fill me-1"></i> Review
                                                    </button>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Modal -->
                        <div class="modal fade" id="reviewModal{{ $transaction->id }}" tabindex="-1"
                            aria-labelledby="reviewModalLabel{{ $transaction->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="border-0 shadow-sm modal-content">
                                    <div class="pb-0 modal-header border-bottom-0">
                                        <h5 class="modal-title" id="reviewModalLabel{{ $transaction->id }}">
                                            How's your experience?
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="pt-2 modal-body">
                                        <div class="mb-4 text-center">
                                            <h4 class="mb-1">{{ $transaction->offer->product->user->name }}</h4>
                                        </div>




                                        <!-- Review Form -->
                                        <form action="{{ route('transactions.review.store', $transaction) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="reviewer_id" value="{{ auth()->id() }}">
                                            <input type="hidden" name="reviewee_id"
                                                value="{{ $transaction->offer->product->user->id }}">
                                            <input type="hidden" name="offer_id" value="{{ $transaction->id }}">
                                            <input type="hidden" name="products_id"
                                                value="{{ $transaction->product->id }}">


                                            <div class="mb-4 text-center star-rating">
                                                <div class="d-flex justify-content-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="mx-1 star fs-2 text-muted"
                                                            data-rating="{{ $i }}" data-bs-toggle="tooltip"
                                                            title="Rate {{ $i }} star(s)">
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" value="0" required>
                                                <small class="mt-2 text-muted d-block">Please select a rating</small>
                                            </div>

                                            <div class="mb-4">
                                                <label for="reviewText{{ $transaction->id }}" class="form-label">
                                                    Your Feedback
                                                </label>
                                                <textarea class="form-control" id="reviewText{{ $transaction->id }}" name="content" rows="4"
                                                    placeholder="Share your experience (optional)"></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100">
                                                Submit Review
                                            </button>
                                        </form>




                                        <!-- Important Note -->
                                        <div class="p-3 mt-4 rounded bg-light">
                                            <p class="mb-0 text-justify small text-muted">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <strong>Community Integrity:</strong> Your honest feedback is vital.
                                                Ratings
                                                and reviews are the backbone of trust in our marketplace. They help
                                                maintain
                                                transparency, guide future transactions, and ensure a fair, reliable
                                                environment for all members. Fabricating reviews undermines the
                                                community's
                                                core values and will not be tolerated.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for the entire page to load
        window.addEventListener('load', function() {
            // Select all review modals
            const reviewModals = document.querySelectorAll('[id^="reviewModal"]');

            // Check if modals exist
            if (reviewModals.length === 0) {
                console.warn('No review modals found');
                return;
            }

            reviewModals.forEach(modal => {
                // Ensure modal exists
                if (!modal) {
                    console.warn('Modal is null');
                    return;
                }

                // Safely select elements
                const starContainer = modal.querySelector('.star-rating');
                if (!starContainer) {
                    console.warn('Star container not found in modal');
                    return;
                }

                const stars = starContainer.querySelectorAll('.star');
                if (stars.length === 0) {
                    console.warn('No stars found in container');
                    return;
                }

                const ratingInput = modal.querySelector('input[name="rating"]');
                if (!ratingInput) {
                    console.warn('Rating input not found');
                    return;
                }

                const submitButton = modal.querySelector('button[type="submit"]');

                // Reset stars to their initial state
                function resetStars(rating = 0) {
                    stars.forEach(star => {
                        const starValue = parseInt(star.getAttribute('data-rating'));
                        const starIcon = star.querySelector('i');

                        if (starValue <= rating) {
                            starIcon.classList.remove('bi-star');
                            starIcon.classList.add('bi-star-fill', 'text-warning');
                        } else {
                            starIcon.classList.remove('bi-star-fill', 'text-warning');
                            starIcon.classList.add('bi-star');
                        }
                    });
                }

                // Attach click event to stars
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        // Get the rating value from the clicked star
                        const rating = this.getAttribute('data-rating');

                        // Explicitly set the input value
                        ratingInput.value = rating;

                        // Reset stars with the new rating
                        resetStars(parseInt(rating));
                    });

                    star.addEventListener('mouseover', function() {
                        const rating = parseInt(this.getAttribute(
                            'data-rating'));
                        stars.forEach(s => {
                            const starValue = parseInt(s.getAttribute(
                                'data-rating'));
                            const starIcon = s.querySelector('i');

                            if (starValue <= rating) {
                                starIcon.classList.remove('bi-star');
                                starIcon.classList.add('bi-star-fill',
                                    'text-warning');
                            } else {
                                starIcon.classList.remove(
                                    'bi-star-fill', 'text-warning');
                                starIcon.classList.add('bi-star');
                            }
                        });
                    });

                    star.addEventListener('mouseout', function() {
                        resetStars(parseInt(ratingInput.value));
                    });
                });

                // Prevent form submission if no rating
                if (submitButton) {
                    submitButton.addEventListener('click', function(e) {
                        // Ensure rating is a number and not zero
                        const currentRating = parseInt(ratingInput.value);

                        if (isNaN(currentRating) || currentRating === 0) {
                            e.preventDefault();
                            alert('Please select a rating before submitting.');

                            // Highlight the star rating area
                            starContainer.classList.add('border', 'border-danger');
                            setTimeout(() => {
                                starContainer.classList.remove('border',
                                    'border-danger');
                            }, 2000);
                        }
                    });
                }

                // Initial setup
                resetStars(0);
            });
        });
    });
</script>

<style>
    .star {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .star:hover {
        transform: scale(1.2);
    }
</style>
