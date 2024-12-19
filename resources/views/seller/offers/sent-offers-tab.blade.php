<div class="tab-pane fade" id="sent-offers" role="tabpanel" aria-labelledby="sent-offers-tab">
    @php
        $deletedOffers = $sentOffers->filter(function ($offer) {
            return !$offer->product;
        });
    @endphp

    @if ($sentOffers->count() > 0)
        <div class="mb-4 shadow-sm card">
            {{-- Header with Clear Deleted Offers Button --}}
            <div class="text-white card-header bg-info d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Sent Offers</h4>
                    <span class="badge bg-light text-info">
                        {{ $sentOffers->count() }} {{ Str::plural('offer', $sentOffers->count()) }}
                    </span>
                </div>

                {{-- Clear Deleted Offers Button --}}
                @if ($deletedOffers->count() > 0)
                    <div>
                        <form action="{{ route('offers.clear-deleted') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>
                                Clear {{ $deletedOffers->count() }} Deleted
                                {{ Str::plural('Offer', $deletedOffers->count()) }}
                            </button>
                        </form>
                    </div>
                @endif
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
                                <tr class="{{ !$offer->product ? 'table-danger' : '' }}">
                                    <td>
                                        @if (!$offer->product)
                                            <div class="text-danger d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                Product has been deleted
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $offer->product->prodImage) }}"
                                                    alt="{{ $offer->product->prodName }}" class="rounded me-3"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h5 class="mb-0 fw-bold">
                                                        {{ Str::limit($offer->product->prodName, 30) }}
                                                    </h5>
                                                    <a
                                                        href="{{ route('profile.user-listing', $offer->product->author->id) }}">
                                                        <small class="text-muted">
                                                            {{ $offer->product->author->name }}
                                                        </small>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold text-muted">
                                            ₱{{ number_format($offer->offer_price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $offer->status == 'accepted'
                                                ? 'bg-success'
                                                : ($offer->status == 'rejected'
                                                    ? 'bg-danger'
                                                    : ($offer->status == 'completed'
                                                        ? 'bg-info'
                                                        : 'bg-warning')) }}">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ \Carbon\Carbon::parse($offer->created_at)->format('M d, Y h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if ($offer->product)
                                            <a href="/marketplace/product/{{ $offer->product->id }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View Product
                                            </a>
                                            <hr class="m-1">
                                            @if ($offer->status == 'accepted')
                                                <a href="{{ route('chat.index') }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-chat me-1"></i>Chat with
                                                    {{ $offer->product->author->name }}
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted">No actions available</span>
                                        @endif
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
