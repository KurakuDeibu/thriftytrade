@auth
    @if (Auth::user()->id == $marketplaceProducts->author->id)
        <div class="container box-border mt-2">
            <h3 class="mb-4">Product Offers
                <span class="badge bg-primary ms-2">{{ $marketplaceProducts->offers->count() }}</span>
            </h3>

            @if ($marketplaceProducts->offers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Buyer</th>
                                <th>Offer Price</th>
                                <th>Meetup Location</th>
                                <th>Meetup Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketplaceProducts->offers->sortByDesc('created_at') as $offer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $offer->user->profile_photo_url }}" alt="{{ $offer->user->name }}"
                                                class="rounded-circle me-2"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold">{{ $offer->user->name }}</div>
                                                <small class="text-muted">{{ $offer->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="
                                                    {{ $offer->status == 'accepted'
                                                        ? 'text-success'
                                                        : ($offer->status == 'rejected'
                                                            ? 'text-danger'
                                                            : 'text-warning') }}
                                                    fw-bold">
                                            ₱{{ number_format($offer->offer_price, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $offer->meetup_location }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($offer->meetup_time)->format('M d, Y h:i A') }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $offer->status == 'accepted' ? 'bg-success' : ($offer->status == 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ ucfirst($offer->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($offer->status == 'accepted')
                                            <a href="{{ route('seller-offers') }}"
                                                class="gap-2 btn btn-outline-primary btn-sm align-items-center">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('chat.chat-message') }}"
                                                class="gap-2 btn btn-outline-primary btn-sm align-items-center">
                                                <i class="bi bi-chat-square"></i>
                                            </a>
                                        @elseif ($offer->status == 'pending')
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-success"
                                                    onclick="updateOfferStatus({{ $offer->id }}, 'accepted')">
                                                    <i class="bi bi-check-circle me-1"></i> Accept
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="updateOfferStatus({{ $offer->id }}, 'rejected')">
                                                    <i class="bi bi-x-circle me-1"></i> Reject
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">No Action</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($marketplaceProducts->offers->count() > 3)
                        <div class="mt-3 text-center">
                            <a wire:navigate.hover href="{{ route('seller-offers') }}" class="btn btn-outline-secondary">
                                View All Offers ({{ $marketplaceProducts->offers->count() }})
                            </a>
                        </div>
                    @endif

                </div>
            @else
                <div class="alert alert-info">
                    No offers have been made for this product yet.
                </div>
            @endif
        </div>

        @push('scripts')
            <script>
                function updateOfferStatus(offerId, status) {
                    const statusConfig = {
                        'accepted': {
                            title: 'Accept Offer',
                            text: 'Are you sure you want to accept this offer?',
                            icon: 'success',
                            confirmButton: 'Accept',
                            confirmClass: 'btn-success'
                        },
                        'rejected': {
                            title: 'Reject Offer',
                            text: 'Are you sure you want to reject this offer?',
                            icon: 'warning',
                            confirmButton: 'Reject',
                            confirmClass: 'btn-danger'
                        }
                    };

                    const config = statusConfig[status];

                    swal({
                        title: config.title,
                        text: config.text,
                        icon: config.icon,
                        buttons: {
                            cancel: {
                                text: "Cancel",
                                value: null,
                                visible: true,
                                className: "btn-secondary"
                            },
                            confirm: {
                                text: config.confirmButton,
                                value: true,
                                visible: true,
                                className: config.confirmClass
                            }
                        },
                        dangerMode: status === 'rejected',
                    }).then((willProceed) => {
                        if (willProceed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('seller.offers.update-status', ':id') }}".replace(':id', offerId);

                            const csrfField = document.createElement('input');
                            csrfField.type = 'hidden';
                            csrfField.name = '_token';
                            csrfField.value = '{{ csrf_token() }}';
                            form.appendChild(csrfField);

                            const methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = 'PATCH';
                            form.appendChild(methodField);

                            const statusField = document.createElement('input');
                            statusField.type = 'hidden';
                            statusField.name = 'status';
                            statusField.value = status;
                            form.appendChild(statusField);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            </script>
        @endpush
    @endif
@endauth