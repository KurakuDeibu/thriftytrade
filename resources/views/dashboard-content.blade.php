<div
    class="px-2 py-2 mb-4 d-flex justify-content-between align-items-center bg-gradient-to-br from-gray-100 to-indigo-100">
    <div class="section-text">
        <h1 class="text-xl navbar-brand">DASHBOARD</h1>
        <h1 class="text-sm text-muted d-flex align-items-center">
            <span class="d-flex align-items-center">
                {{ Auth::user()->name }}
                @if (Auth::user()->finder_status == 'approved')
                    <span class="rounded-md badge bg-primary ms-2 d-flex align-items-center" title="Verified Finder">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="handshake"
                            class="svg-inline--fa fa-handshake" role="img" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 512" style="width: 0.8rem; height: 0.8rem;">
                            <path fill="currentColor"
                                d="M323.4 85.2l-96.8 78.4c-16.1 13-19.2 36.4-7 53.1c12.9 17.8 38 21.3 55.3 7.8l99.3-77.2c7-5.4 17-4.2 22.5 2.8s4.2 17-2.8 22.5l-20.9 16.2L512 316.8V128h-.7l-3.9-2.5L434.8 79c-15.3-9.8-33.2-15-51.4-15c-21.8 0-43 7.5-60 21.2zm22.8 124.4l-51.7 40.2C263 274.4 217.3 268 193.7 235.6c-22.2-30.5-16.6-73.1 12.7-96.8l83.2-67.3c-11.6-4.9-24.1-7.4-36.8-7.4C234 64 215.7 69.6 200 80l-72 48V352h28.2l91.4 83.4c19.6 17.9 49.9 16.5 67.8-3.1c5.5-6.1 9.2-13.2 11.1-20.6l17 15.6c19.5 17.9 49.9 16.6 67.8-2.9c4.5-4.9 7.8-10.6 9.9-16.5c19.4 13 45.8 10.3 62.1-7.5c17.9-19.5 16.6-49.9-2.9-67.8l-134.2-123zM16 128c-8.8 0-16 7.2-16 16V352c0 17.7 14.3 32 32 32H64c17.7 0 32-14.3 32-32V128H16zM48 320a16 16 0 1 1 0 32 16 16 0 1 1 0-32zM544 128V352c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V144c0-8.8-7.2-16-16-16H544zm32 208a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z">
                            </path>
                        </svg>
                    </span>
                @endif
            </span>
        </h1>
    </div>
    <button class="btn btn-primary"><i class="bi bi-graph-up-arrow"> </i>Generate Reports</button>
</div>

<div class="mb-4 row">
    <div class="mb-3 col-md-4">
        <div class="p-4 bg-white rounded shadow-sm stat-card-custom position-relative hover-effect">
            <div class="d-flex justify-content-between">
                <div class="p-3 mb-3 card-icon-bg rounded-circle bg-primary bg-opacity-10">
                    <i class="fas fa-shopping-bag text-primary fa-2x"></i>
                </div>
                <a href="{{ route('manage-listing') }}" class="text-muted" title="View All Listings">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-2 text-muted">Active Listings</div>
            <div class="mb-0 h3">{{ $activeProducts->count() }}</div>
        </div>
    </div>

    <div class="mb-3 col-md-4">
        <div class="p-4 bg-white rounded shadow-sm stat-card-custom position-relative hover-effect">
            <div class="d-flex justify-content-between">
                <div class="p-3 mb-3 card-icon-bg rounded-circle bg-success bg-opacity-10">
                    <i class="fas fa-tags text-success fa-2x"></i>
                </div>
                <a href="{{ route('manage-listing') }}#Sold" class="text-muted" title="View Sold Listings">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-2 text-muted">Items Sold</div>
            <div class="mb-0 h3">{{ $soldProducts->count() }}</div>
        </div>
    </div>

    {{-- <div class="mb-3 col-md-4">
        <div class="p-4 bg-white rounded shadow-sm stat-card-custom position-relative hover-effect">
            <div class="d-flex justify-content-between">
                <div class="p-3 mb-3 card-icon-bg rounded-circle bg-warning bg-opacity-10">
                    <i class="fas fa-peso-sign text-warning fa-2x"></i>
                </div>
                <a href="" class="text-muted" title="View Earnings">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-2 text-muted">Total Earnings</div>
            <div class="mb-0 h3">₱{{ $soldProducts->sum('offer_price') }}</div>
        </div>
    </div> --}}

    <div class="mb-3 col-md-4">
        <div class="p-4 bg-white rounded shadow-sm stat-card-custom position-relative hover-effect">
            <div class="d-flex justify-content-between">
                <div class="p-3 mb-3 card-icon-bg rounded-circle bg-info bg-opacity-10">
                    <i class="fas fa-star text-info fa-2x"></i>
                </div>
                <a href="{{ route('profile.user-listing', Auth::user()->id) }}" class="text-muted" title="View Ratings">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-2 text-muted">Average Rating</div>
            <div class="mb-0 h3">{{ number_format($averageRating, 1) }}<span class="h6">/ 5</span></div>
        </div>
    </div>


    <div class="mb-3 col-md-8">
        <div class="p-3 bg-white rounded shadow-sm stat-card-custom position-relative hover-effect">
            <div class="d-flex justify-content-between align-items-center">
                <div class="p-2 mb-2 card-icon-bg rounded-circle bg-info bg-opacity-10">
                    <i class="fas fa-file-alt text-info fa-2x"></i>
                </div>
                <a href="" class="text-muted" title="View Offers">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-1 text-center text-muted h5">OFFERS</div>
            <ul class="mt-2 list-group">
                <li class="p-2 list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-clock text-warning fa-lg"></i>
                        <span class="ms-2 small">Pending</span>
                    </div>
                    <span class="badge bg-warning rounded-pill">{{ $pendingOffers->count() }}</span>
                </li>
                <li class="p-2 list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                        <span class="ms-2 small">Accepted</span>
                    </div>
                    <span class="badge bg-success rounded-pill">{{ $acceptedOffers->count() }}</span>
                </li>
                <li class="p-2 list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-times-circle text-danger fa-lg"></i>
                        <span class="ms-2 small">Rejected</span>
                    </div>
                    <span class="badge bg-danger rounded-pill">{{ $rejectedOffers->count() }}</span>
                </li>
                <li class="p-2 list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-check-double text-primary fa-lg"></i>
                        <span class="ms-2 small">Completed</span>
                    </div>
                    <span class="badge bg-primary rounded-pill">{{ $completedOffers->count() }}</span>
                </li>
            </ul>
        </div>
    </div>
    {{-- RECENT OFFERS/PENDING OFFERS  --}}
    {{-- -------------------------- --}}
</div>


<style>
    .stat-card-custom {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgb(45, 56, 255);
    }

    .card-icon-bg {
        width: fit-content;
        height: fit-content;
    }

    .stat-card-custom a {
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .stat-card-custom a:hover {
        color: #000 !important;
    }
</style>
