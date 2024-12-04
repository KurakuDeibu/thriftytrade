<div class="tab-container mt-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="px-2 text-lg navbar-brand">MANAGE OFFERS</h1>
    </div>
    <div class="col">
        @if ($pendingOffers->count() > 0)
            <div class="alert alert-warning">
                You have {{ $pendingOffers->count() }} pending {{ Str::plural('offer', $pendingOffers->count()) }}
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
                Pending ({{ $pendingOffers->count() }})
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
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sent-offers-tab" data-bs-toggle="tab" data-bs-target="#sent-offers"
                type="button" role="tab" aria-controls="sent-offers" aria-selected="false">
                Sent Offers ({{ $sentOffers->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="offerTabsContent">

        <!-- Pending Offers Tab -->
        @include('seller.offers.pending-offers-tab')

        <!-- Accepted Offers Tab -->
        @include('seller.offers.accepted-offers-tab')

        <!-- Rejected Offers Tab -->
        @include('seller.offers.rejected-offers-tab')

        {{-- NO OFFERS TAB --}}
        @include('seller.offers.no-offers-tab')

        <!-- New tab pane for sent offers (buyer) -->
        @include('seller.offers.sent-offers-tab')
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

@push('scripts')
    <script>
        function updateOfferStatus(offerId, status) {
            const statusText = status === 'accepted' ?
                'accept this offer' :
                'reject this offer';

            const buttonClass = status === 'accepted' ?
                'btn-success' :
                'btn-danger';

            swal({
                title: `${status.charAt(0).toUpperCase() + status.slice(1)} Offer`,
                text: `Are you sure you want to ${statusText}?`,
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn-secondary"
                    },
                    confirm: {
                        text: status.charAt(0).toUpperCase() + status.slice(1),
                        value: true,
                        visible: true,
                        className: buttonClass
                    }
                },
                dangerMode: status === 'rejected',
            }).then((willProceed) => {
                if (willProceed) {
                    // Create a form to submit the status update
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('seller.offers.update-status', ':id') }}".replace(':id', offerId);

                    // Add CSRF token
                    const csrfField = document.createElement('input');
                    csrfField.type = 'hidden';
                    csrfField.name = '_token';
                    csrfField.value = '{{ csrf_token() }}';
                    form.appendChild(csrfField);

                    // Add method field to indicate PATCH
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PATCH';
                    form.appendChild(methodField);

                    // Add status field
                    const statusField = document.createElement('input');
                    statusField.type = 'hidden';
                    statusField.name = 'status';
                    statusField.value = status;
                    form.appendChild(statusField);

                    // Append the form to the body and submit it
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endpush
