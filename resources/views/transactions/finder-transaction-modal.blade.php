<!-- Offer Details Modal (from previous response) -->
@if ($selectedOffer)
    <div wire:ignore.self class="modal fade" id="offerDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="shadow-lg modal-content">
                <div class="pb-0 modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-receipt-cutoff text-primary me-2"></i>
                        Commission Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Offer Overview -->
                        <div class="col-md-4">
                            <div class="border-0 shadow-sm card h-100">
                                <div class="card-body">
                                    <div class="mb-3 d-flex align-items-center">
                                        <p>{{ __('') }}</p>
                                        <img src="{{ $selectedOffer->user->profile_photo_url }}"
                                            alt="{{ $selectedOffer->user->name }}" class="rounded-circle me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1">{{ $selectedOffer->user->name }}</h6>
                                            <small class="text-muted">{{ $selectedOffer->user->email }}</small>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            Offered on {{ $selectedOffer->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Offer Financial Details -->
                        <div class="col-md-8">
                            <div class="border-0 shadow-sm card h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 rounded bg-primary-soft me-3">
                                                    <i class="bi bi-cash-stack text-primary"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Offer Price</small>
                                                    <h6 class="mb-0 text- primary fw-bold">
                                                        ₱{{ number_format($selectedOffer->offer_price, 2) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 rounded bg-success-soft me-3">
                                                    <i class="bi bi-cash-coin text-success"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Finder's Fee</small>
                                                    <h6 class="mb-0 text-success fw-bold">
                                                        ₱{{ number_format($selectedOffer->offered_finders_fee ?? 0, 2) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Meetup Location:</strong>
                                        <p>{{ $selectedOffer->meetup_location }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Meetup Time:</strong>
                                        <p>{{ \Carbon\Carbon::parse($selectedOffer->meetup_time)->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                    <div class="mb-3">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
