<div>
    @auth
        <hr>
        <div class="container box-border mt-2">
            <h3 class="mb-4">
                Your Offer for this Listing
                <span class="badge bg-primary ms-2">{{ $offers->count() }}</span>
            </h3>

            @if ($offers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Offer Price</th>
                                <th>Meetup Details</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers->sortByDesc('created_at') as $offer)
                                <tr>
                                    <td class="px-4 m-2">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <span
                                                    class="
                                            {{ $offer->status == 'accepted'
                                                ? 'text-success'
                                                : ($offer->status == 'rejected'
                                                    ? 'text-danger'
                                                    : ($offer->status == 'completed'
                                                        ? 'text-primary'
                                                        : 'text-warning')) }}
                                            fw-bold">
                                                    ₱{{ number_format($offer->offer_price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 m-2">
                                        <div>
                                            <div class="text-sm fw-bold">
                                                <i class="bi bi-geo-alt"></i>
                                                {{ $offer->meetup_location }}
                                            </div>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($offer->meetup_time)->format('M d, Y h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 m-2">
                                        <span
                                            class="badge
                                        {{ $offer->status == 'accepted'
                                            ? 'bg-success'
                                            : ($offer->status == 'rejected'
                                                ? 'bg-danger'
                                                : ($offer->status == 'completed'
                                                    ? 'bg-primary'
                                                    : 'bg-warning')) }}">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 m-2">
                                        <div class="btn-group" role="group">


                                            @if ($offer->status == 'pending')
                                                <a href="{{ route('seller-offers') }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-paper-plane"></i> View Sent Offers
                                                </a>
                                            @endif

                                            @if ($offer->status == 'accepted')
                                                <button wire:click="viewOfferDetails({{ $offer->id }})"
                                                    class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#offerDetailsModal">
                                                    <i class="bi bi-eye"></i> View
                                                </button>
                                            @endif

                                            @if ($offer->status == 'completed')
                                                <button wire:click="viewOfferDetails({{ $offer->id }})"
                                                    class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#offerDetailsModal">
                                                    <i class="bi bi-eye"></i> View Transaction
                                                </button>
                                                <a href="{{ route('user.transactions') }}"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-star"></i> Review
                                                </a>
                                            @endif

                                            @if ($offer->status == 'accepted')
                                                {{-- <a href="{{ route('chat.conversation', $offer->id) }}" --}}
                                                <a href="" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-chat-square"></i> Message {{ $offer->user->name }}
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($offers->count() > 3)
                    <div class="mt-3 text-center">
                        <a href="{{ route('seller-offers') }}" class="btn btn-outline-secondary d-inline">
                            View All Offers ({{ $offers->count() }})
                        </a>
                    </div>
                @endif
            @else
                <div class="alert alert-primary">
                    You haven't made any offers yet.
                </div>
            @endif

            <!-- Offer Details Modal (from previous response) -->
            @if ($selectedOffer)
                <div wire:ignore.self class="modal fade" id="offerDetailsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="text-white modal-header bg-primary">
                                <h5 class="modal-title">
                                    @if (auth()->id() == $selectedOffer->product->author_id)
                                        Offer from Buyer
                                    @else
                                        Offer Details
                                    @endif
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{-- Product Information --}}
                                    <div class="mb-4 col-12">
                                        <div class="card">
                                            <div class="card-header bg-light d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $selectedOffer->product->prodImage) }}"
                                                    alt="{{ $selectedOffer->product->prodName }}" class="rounded me-3"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h5 class="mb-1">{{ $selectedOffer->product->name }}</h5>
                                                    <small class="text-muted">
                                                        {{ $selectedOffer->product->category->categName ?? 'No Category' }}
                                                    </small>
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
                                                                alt="{{ $selectedOffer->user->name }}"
                                                                class="rounded-circle me-3"
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
                                                                <strong>Offer Price:</strong>
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endauth
</div>
