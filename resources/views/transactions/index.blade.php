<div class="container-fluid marketplace-listings">
    <div class="mb-4 row align-items-center">
        <div class="col">
            <h1 class="px-2 text-lg navbar-brand">MY TRANSACTIONS</h1>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="row row-cols-1 g-4">
                @forelse ($transactions as $transaction)
                    <div class="col-lg-12">
                        <div class="card listing-card position-relative border-primary">
                            <div class="row g-0">
                                <!-- Product Image -->
                                <div class="col-md-4 position-relative">
                                    <div class="h-100 listing-image-container">
                                        <img src="{{ $transaction->product->prodImage && file_exists(public_path('storage/' . $transaction->product->prodImage))
                                            ? asset('storage/' . $transaction->product->prodImage)
                                            : asset('img/NOIMG.jpg') }}"
                                            class="border-2 card-img-top listing-image w-100 h-100 object-fit-cover"
                                            alt="{{ $transaction->product->prodName }}">
                                    </div>
                                </div>

                                <!-- Transaction Details -->
                                <div class="col-md-8 position-relative">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-2 d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="mb-1 card-title">
                                                    {{ Str::limit($transaction->product->prodName, 50) }}
                                                </h5>
                                                <p class="mb-0 text-muted small">
                                                    Sold to: {{ $transaction->user->name }} •
                                                    {{ $transaction->updated_at->format('M d, Y') }} @
                                                    {{ $transaction->updated_at->format('h:i A') }}
                                                </p>
                                            </div>


                                            <!-- Transaction Actions -->
                                            <div class="mb-1 text-primary h4">
                                                ₱{{ number_format($transaction->offer_price, 2) }}
                                            </div>

                                        </div>

                                        <hr>

                                        <div class="mt-2 mb-2 row">
                                            <div class="col-md-12">
                                                <div class="mb-1 text-sm text-muted">
                                                    Original Price:
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
                                            <a href="/marketplace/product/{{ $transaction->product->id }}"
                                                type="button" class="btn btn-outline-primary w-50"
                                                title="View Details">
                                                <i class="bi bi-eye me-1"></i> View Details
                                            </a>
                                            <button class="btn btn-outline-warning w-50" data-bs-toggle="modal"
                                                data-bs-target="#reviewModal{{ $transaction->id }}" title="Add Review">
                                                <i class="bi bi-star-fill me-1"></i> Review
                                            </button>
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
                                        <h4 class="mb-1">{{ $transaction->user->name }}</h4>
                                    </div>

                                    <!-- Dynamic Star Rating -->
                                    <div class="mb-4 text-center star-rating">
                                        <div class="d-flex justify-content-center" id="starContainer">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="mx-1 star fs-2 text-muted"
                                                    data-rating="{{ $i }}">
                                                    <i class="bi bi-star"></i>
                                                </span>
                                            @endfor
                                        </div>
                                        <input type="hidden" id="selectedRating" name="rating" value="0">
                                    </div>

                                    <!-- Review Form -->
                                    <form>
                                        <div class="mb-4">
                                            <label for="reviewText" class="form-label">Your Feedback</label>
                                            <textarea class="form-control" id="reviewText" rows="4" placeholder="Share your experience (optional)"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                                    </form>

                                    <!-- Important Note -->
                                    <div class="p-3 mt-4 rounded bg-light">
                                        <p class="mb-0 text-justify small text-muted">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Community Integrity:</strong> Your honest feedback is vital. Ratings
                                            and reviews are the backbone of trust in our marketplace. They help maintain
                                            transparency, guide future transactions, and ensure a fair, reliable
                                            environment for all members. Fabricating reviews undermines the community's
                                            core values and will not be tolerated.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mb-4">
                        <div class="p-4 text-center bg-white rounded shadow-sm stat-card-custom">
                            <div class="p-3 mx-auto mb-3">
                                <i class="fas fa-inbox text-secondary fa-3x"></i>
                            </div>
                            <h5 class="mb-2 text-muted">You have empty transactions at the moment.</h5>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starContainer = document.getElementById('starContainer');
        const selectedRatingInput = document.getElementById('selectedRating');
        const stars = starContainer.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                stars.forEach(s => {
                    const starRating = parseInt(s.getAttribute('data-rating'));
                    if (starRating <= rating) {
                        s.innerHTML = '<i class="bi bi-star-fill text-warning"></i>';
                    } else {
                        s.innerHTML = '<i class="bi bi-star text-muted"></i>';
                    }
                });
            });

            star.addEventListener('mouseout', function() {
                const currentRating = selectedRatingInput.value;
                stars.forEach(s => {
                    const starRating = parseInt(s.getAttribute('data-rating'));
                    if (starRating <= currentRating) {
                        s.innerHTML = '<i class="bi bi-star-fill text-warning"></i>';
                    } else {
                        s.innerHTML = '<i class="bi bi-star text-muted"></i>';
                    }
                });
            });

            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                selectedRatingInput.value = rating;
                stars.forEach(s => {
                    const starRating = parseInt(s.getAttribute('data-rating'));
                    if (starRating <= rating) {
                        s.innerHTML = '<i class="bi bi-star-fill text-warning"></i>';
                    } else {
                        s.innerHTML = '<i class="bi bi-star text-muted"></i>';
                    }
                });
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
