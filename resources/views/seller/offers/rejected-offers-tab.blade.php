<div class="tab-pane fade" id="rejected-offers" role="tabpanel" aria-labelledby="rejected-offers-tab">
    @if ($rejectedOffers->count() > 0)
        @foreach ($groupedOffers as $productId => $productOffers)
            @php
                $product = $productOffers->first()->product;
                $rejectedOffers = $productOffers->where('status', 'rejected');
            @endphp
            @if ($rejectedOffers->isNotEmpty())
                <div class="mb-4 shadow-sm card">
                    <div class="text-white card-header bg-danger">
                        <div class="flex-wrap d-flex justify-content-between align-items-center">
                            <div class="mb-2 d-flex align-items-center mb-md-0">
                                <img src="{{ asset('storage/' . $product->prodImage) }}" alt="{{ $product->prodName }}"
                                    class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h4 class="mb-0">{{ Str::limit($product->prodName, 30) }}</h4>
                                    <p class="mb-0 text-muted">Listed Price:
                                        ₱{{ number_format($product->prodPrice, 2) }}</p>
                                </div>
                            </div>
                            <a href="/marketplace/product/{{ $product->id }}">
                                <i class="text-white fas fa-external-link-alt"></i>
                                <span class="badge bg-light text-danger">{{ $rejectedOffers->count() }}
                                    {{ Str::plural('offer', $rejectedOffers->count()) }}</span>
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
                                    @foreach ($rejectedOffers as $offer)
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
                                                <span class="fw-bold text-danger">
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
                <h5 class="mb-2 text-muted">No rejected offers.</h5>
            </div>
        </div>
    @endif
</div>
