<div class="tab-pane fade show active" id="pending-offers" role="tabpanel" aria-labelledby="pending-offers-tab">
    @if ($pendingOffers->count() > 0)
        @foreach ($groupedOffers as $productId => $productOffers)
            @php
                $product = $productOffers->first()->product;
                $pendingOffers = $productOffers->where('status', 'pending');
            @endphp
            @if ($pendingOffers->isNotEmpty())
                <div class="mb-4 shadow-sm card">
                    <div class="card-header bg-warning text-dark">
                        <div class="flex-wrap d-flex justify-content-between align-items-center">
                            <div class="mb-2 d-flex align-items-center mb-md-0">
                                <img src="{{ asset('storage/' . $product->prodImage) }}" alt="{{ $product->prodName }}"
                                    class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h4 class="mb-0">{{ Str::limit($product->prodName, 30) }}</h4>
                                    <p class="mb-0">Listed Price:
                                        ₱{{ number_format($product->prodPrice, 2) }}
                                    </p>
                                </div>
                            </div>
                            <a href="/marketplace/product/{{ $product->id }}">
                                <i class="text-white fas fa-external-link-alt"></i>
                                <span class="badge bg-primary">{{ $pendingOffers->count() }}
                                    {{ Str::plural('offer', $pendingOffers->count()) }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead>
                                    <tr>
                                        <th>Buyer</th>
                                        <th>Offer Amount</th>
                                        <th>Meetup Details</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingOffers as $offer)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $offer->user->profile_photo_url }}"
                                                        alt="{{ $offer->user->name }}" class="rounded-circle me-2"
                                                        style="width: 40px; height: 40px;">
                                                    <div>
                                                        <div class="fw-bold">{{ $offer->user->name }}</div>
                                                        <small class="text-muted">{{ $offer->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="fw-bold {{ $offer->offer_price >= $product->prodPrice ? 'text-success' : 'text-danger' }}">
                                                    ₱{{ number_format($offer->offer_price, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $offer->meetup_location }}<br>
                                                    <i class="bi bi-clock"></i>
                                                    {{ \Carbon\Carbon::parse($offer->meetup_time)->format('M d, Y h:i A') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#messageModal{{ $offer->id }}">
                                                        <i class="bi bi-chat-text me-1"></i>Message
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="updateOfferStatus({{ $offer->id }}, 'accepted')">
                                                        <i class="bi bi-check-circle me-1"></i>Accept
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="updateOfferStatus({{ $offer->id }}, 'rejected')">
                                                        <i class="bi bi-x-circle me-1"></i>Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="mb-4">
            <div class="p-4 text-center bg-white rounded shadow-sm stat-card-custom">
                <div class="p-3 mx-auto mb-3">
                    <i class="fas fa-inbox text-secondary fa-3x"></i>
                </div>
                <h5 class="mb-2 text-muted">No pending offers</h5>
                <p class="mb-0">At the moment, there are no pending offers to review.</p>
            </div>
        </div>
    @endif

</div>
