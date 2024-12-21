<!-- Offer Details Modal (from previous response) -->
@if ($selectedOffer)
    <div wire:ignore.self class="modal fade" id="transactionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-white modal-header bg-primary">
                    <h5 class="modal-title">
                        @if (auth()->id() == $selectedOffer->product->author_id)
                            Transaction from Buyer
                        @else
                            Transaction Details
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Product Information --}}
                        <div class="mb-4 col-12">
                            <div class="card">
                                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $selectedOffer->product->prodImage) }}"
                                            alt="{{ $selectedOffer->product->prodName }}" class="rounded me-3"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h5 class="mb-1 fw-bold">{{ $selectedOffer->product->prodName }}</h5>
                                            <small class="text-muted">
                                                {{ $selectedOffer->product->category->categName ?? 'No Category' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-muted">
                                        {{ number_format($selectedOffer->product->prodPrice, 2) }} PHP
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                {{-- Seller Information --}}
                                <div class="mb-3 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Seller Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $selectedOffer->product->author->profile_photo_url ?? asset('default-avatar.png') }}"
                                                    alt="{{ $selectedOffer->product->author->name }}"
                                                    class="rounded-circle me-3"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">
                                                        {{ $selectedOffer->product->author->name }}</h6>
                                                    <small class="text-muted">
                                                        {{ $selectedOffer->product->author->email }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Buyer Information --}}
                                <div class="mb-3 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Buyer Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $selectedOffer->user->profile_photo_url ?? asset('default-avatar.png') }}"
                                                    alt="{{ $selectedOffer->user->name }}" class="rounded-circle me-3"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ $selectedOffer->user->name }}</h6>
                                                    <small class="text-muted">
                                                        {{ $selectedOffer->user->email }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Offer Status and Meetup Details --}}
                                <div class="mb-3 col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Transaction Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-2 col-md-6">
                                                    <strong>Status:</strong>
                                                    <span
                                                        class="badge
                                        {{ $selectedOffer->status == 'accepted'
                                            ? 'bg-success'
                                            : ($selectedOffer->status == 'rejected'
                                                ? 'bg-danger'
                                                : ($selectedOffer->status == 'completed'
                                                    ? 'bg-primary'
                                                    : 'bg-warning')) }}">
                                                        {{ ucfirst($selectedOffer->status) }}
                                                    </span>
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <strong>Date Accepted:</strong>
                                                    <p>
                                                        @if ($selectedOffer->status == 'completed')
                                                            {{ \Carbon\Carbon::parse($selectedOffer->updated_at)->format('M d, Y h:i A') }}
                                                        @else
                                                            Not applicable
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <strong>Accepted Offer Price:</strong>
                                                    <p class="text-primary fw-bold">
                                                        ₱{{ number_format($selectedOffer->offer_price, 2) }}
                                                    </p>
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <strong>Meetup Location:</strong>
                                                    <p>
                                                        <i class="bi bi-geo-alt text-primary me-2"></i>
                                                        {{ $selectedOffer->meetup_location ?? 'No location specified' }}
                                                    </p>
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <strong>Meetup Time:</strong>
                                                    <p>
                                                        <i class="bi bi-clock text-primary me-2"></i>
                                                        {{ \Carbon\Carbon::parse($selectedOffer->meetup_time)->format('M d, Y h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" href="{{ route('offers.generate-pdf', ['offerId' => $selectedOffer->id]) }}"
                        class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf"></i> Generate Reports
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
