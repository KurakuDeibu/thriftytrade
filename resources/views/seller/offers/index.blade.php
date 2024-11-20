<div class="container mt-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="px-2 text-lg navbar-brand">MANAGE OFFERS</h1>
        <a href="{{ route('listing.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create New
        </a>
    </div>
    <div class="col">
        @if ($pendingOffersCount > 0)
            <div class="alert alert-primary">
                You have {{ $pendingOffersCount }} pending {{ Str::plural('offer', $pendingOffersCount) }}
                to
                review.
            </div>
        @endif
    </div>


    <ul class="mb-3 nav nav-tabs" id="offerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-offers-tab" data-bs-toggle="tab"
                data-bs-target="#pending-offers" type="button" role="tab" aria-controls="pending-offers"
                aria-selected="true">
                Pending ({{ $pendingOffersCount }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="accepted-offers-tab" data-bs-toggle="tab" data-bs-target="#accepted-offers"
                type="button" role="tab" aria-controls="accepted-offers" aria-selected="false">
                Accepted ({{ $acceptedOffers->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rejected-offers-tab" data-bs-toggle="tab" data-bs-target="#rejected-offers"
                type="button" role="tab" aria-controls="rejected-offers" aria-selected="false">
                Rejected ({{ $rejectedOffers->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="no-offers-tab" data-bs-toggle="tab" data-bs-target="#no-offers" type="button"
                role="tab" aria-controls="no-offers" aria-selected="false">
                No Offers ({{ $productsWithNoOffers->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="offerTabsContent">

        <!-- Pending Offers Tab -->
        <div class="tab-pane fade show active" id="pending-offers" role="tabpanel" aria-labelledby="pending-offers-tab">
            @if ($pendingOffersCount > 0)
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
                                        <img src="{{ asset('storage/' . $product->prodImage) }}"
                                            alt="{{ $product->prodName }}" class="rounded me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h4 class="mb-0">{{ $product->prodName }}</h4>
                                            <p class="mb-0">Listed Price:
                                                ₱{{ number_format($product->prodPrice, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary">{{ $pendingOffers->count() }}
                                        {{ Str::plural('offer', $pendingOffers->count()) }}</span>
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
                                                                alt="{{ $offer->user->name }}"
                                                                class="rounded-circle me-2"
                                                                style="width: 40px; height: 40px;">
                                                            <div>
                                                                <div class="fw-bold">{{ $offer->user->name }}</div>
                                                                <small
                                                                    class="text-muted">{{ $offer->user->email }}</small>
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
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#messageModal{{ $offer->id }}">
                                                                <i class="bi bi-chat-text me-1"></i>Message
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#acceptOfferModal{{ $offer->id }}">
                                                                <i class="bi bi-check-circle me-1"></i>Accept
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectOfferModal{{ $offer->id }}">
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
                <div class="p-5 mt-3 text-center " role="alert">
                    <div class="alert alert-primary">
                        No pending offers at the moment.</div>
                </div>
            @endif

        </div>

        <!-- Accepted Offers Tab -->
        <div class="tab-pane fade" id="accepted-offers" role="tabpanel" aria-labelledby="accepted-offers-tab">
            @if ($acceptedOffers->count() > 0)
                @foreach ($groupedOffers as $productId => $productOffers)
                    @php
                        $product = $productOffers->first()->product;
                        $acceptedOffers = $productOffers->where('status', 'accepted');
                    @endphp
                    @if ($acceptedOffers->isNotEmpty())
                        <div class="mb-4 shadow-sm card">
                            <div class="text-white card-header bg-success">
                                <div class="flex-wrap d-flex justify-content-between align-items-center">
                                    <div class="mb-2 d-flex align-items-center mb-md-0">
                                        <img src="{{ asset('storage/' . $product->prodImage) }}"
                                            alt="{{ $product->prodName }}" class="rounded me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h4 class="mb-0">{{ $product->prodName }}</h4>
                                            <p class="mb-0 text-muted">Listed Price:
                                                ₱{{ number_format($product->prodPrice, 2) }}</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-success">{{ $acceptedOffers->count() }}
                                        {{ Str::plural('offer', $acceptedOffers->count()) }}</span>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($acceptedOffers as $offer)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $offer->user->profile_photo_url }}"
                                                                alt="{{ $offer->user->name }}"
                                                                class="rounded-circle me-2"
                                                                style="width: 40px; height: 40px;">
                                                            <div>
                                                                <div class="fw-bold">{{ $offer->user->name }}</div>
                                                                <small
                                                                    class="text-muted">{{ $offer->user->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
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
                <div class="p-5 mt-3 text-center " role="alert">
                    <div class="alert alert-primary">
                        Accepted offers will display here.</div>
                </div>
            @endif
        </div>

        <!-- Rejected Offers Tab -->
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
                                        <img src="{{ asset('storage/' . $product->prodImage) }}"
                                            alt="{{ $product->prodName }}" class="rounded me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <h4 class="mb-0">{{ $product->prodName }}</h4>
                                            <p class="mb-0 text-muted">Listed Price:
                                                ₱{{ number_format($product->prodPrice, 2) }}</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-danger">{{ $rejectedOffers->count() }}
                                        {{ Str::plural('offer', $rejectedOffers->count()) }}</span>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rejectedOffers as $offer)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $offer->user->profile_photo_url }}"
                                                                alt="{{ $offer->user->name }}"
                                                                class="rounded-circle me-2"
                                                                style="width: 40px; height: 40px;">
                                                            <div>
                                                                <div class="fw-bold">{{ $offer->user->name }}</div>
                                                                <small
                                                                    class="text-muted">{{ $offer->user->email }}</small>
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
                <div class="p-5 mt-3 text-center " role="alert">
                    <div class="alert alert-primary">
                        Rejected offers will display here.</div>
                </div>
            @endif
        </div>
        {{-- NO OFFERS TAB --}}
        <div class="tab-pane fade" id="no-offers" role="tabpanel" aria-labelledby="no-offers-tab">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Products without Offers</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Listed Price</th>
                                    <th>Date Listed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productsWithNoOffers as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $product->prodImage) }}"
                                                    alt="{{ $product->prodName }}" class="rounded me-3"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                <div>{{ $product->prodName }}</div>
                                            </div>
                                        </td>
                                        <td>₱{{ number_format($product->prodPrice, 2) }}</td>
                                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a type="button" href="/marketplace/product/{{ $product->id }}"
                                                class="btn btn-sm btn-outline-primary fas fa-eye"></a>
                                            <a type="button" href="{{ route('listing.edit', $product->id) }}"
                                                class="btn btn-sm btn-outline-primary fas fa-edit"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- Modals -->
    @foreach ($groupedOffers as $productId => $productOffers)
        @foreach ($productOffers as $offer)
            <!-- Message Modal -->
            <div class="modal fade" id="messageModal{{ $offer->id }}" tabindex="-1"
                aria-labelledby="messageModalLabel{{ $offer->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="messageModalLabel{{ $offer->id }}">Message from
                                {{ $offer->user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{ $offer->message }}
                        </div>
                        <div class="modal-footer">
                            <a href="/marketplace/chat">
                                <button type="button" class="btn btn-outline-primary">Show Messages</button>
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accept Offer Modal -->
            <div class="modal fade" id="acceptOfferModal{{ $offer->id }}" tabindex="-1"
                aria-labelledby="acceptOfferModalLabel{{ $offer->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="acceptOfferModalLabel{{ $offer->id }}">Accept Offer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to accept this offer of ₱{{ number_format($offer->offer_price, 2) }}
                            from {{ $offer->user->name }}?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('seller.offers.update-status', $offer->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reject Offer Modal -->
            <div class="modal fade" id="rejectOfferModal{{ $offer->id }}" tabindex="-1"
                aria-labelledby="rejectOfferModalLabel{{ $offer->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectOfferModalLabel{{ $offer->id }}">Reject Offer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to reject this offer of ₱{{ number_format($offer->offer_price, 2) }}
                            from {{ $offer->user->name }}?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('seller.offers.update-status', $offer->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>

<style>
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>
