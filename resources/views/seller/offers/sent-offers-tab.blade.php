<div class="tab-pane fade" id="sent-offers" role="tabpanel" aria-labelledby="sent-offers-tab">
    @if ($sentOffers->count() > 0)
        <div class="mb-4 shadow-sm card">
            <div class="text-white card-header bg-info">
                <h4 class="mb-0">Sent Offers</h4>
                <span class="badge bg-light text-info">{{ $sentOffers->count() }}
                    {{ Str::plural('offer', $sentOffers->count()) }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <th>Product Info</th>
                                <th>Offered Price</th>
                                <th>Status</th>
                                <th>Sent On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sentOffers as $offer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $offer->product->prodImage) }}"
                                                alt="{{ $offer->product->prodName }}" class="rounded me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h5 class="mb-0 fw-bold">
                                                    {{ Str::limit($offer->product->prodName, 30) }}</h5>
                                                <a
                                                    href="{{ route('profile.user-listing', $offer->product->author->id) }}">
                                                    <small
                                                        class="text-muted">{{ $offer->product->author->name }}</small></a>
                                                <small class="text-muted">{{ $offer->product->author->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-info">
                                            ₱{{ number_format($offer->offer_price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $offer->status == 'accepted' ? 'bg-success' : ($offer->status == 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ \Carbon\Carbon::parse($offer->created_at)->format('M d, Y h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="/marketplace/product/{{ $offer->product->id }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>View Product
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="mb-4">
            <div class="p-4 text-center bg-white rounded shadow-sm stat-card-custom">
                <div class="p-3 mx-auto mb-3">
                    <i class="fas fa-inbox text-secondary fa-3x"></i>
                </div>
                <h5 class="mb-2 text-muted">No sent offers</h5>
                <p class="mb-0">At the moment, there are no sent offers to show.</p>
            </div>
        </div>
    @endif
</div>
