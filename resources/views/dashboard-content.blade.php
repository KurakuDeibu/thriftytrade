<div class="mb-4 d-flex justify-content-between align-items-center">
    <h1 class="navbar-brand">{{ Auth::user()->name }}'s Dashboard</h1>
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
                <a href="{{ route('manage-listing') }}#sold" class="text-muted" title="View Sales">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-2 text-muted">Items Sold</div>
            <div class="mb-0 h3">{{ $soldProducts->count() }}</div>
        </div>
    </div>

    <div class="mb-3 col-md-4">
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
            <div class="mb-0 h3">₱{{ $soldProducts->sum('prodPrice') }}</div>
        </div>
    </div>

    <div class="mb-3 col-md-4">
        <div class="p-4 bg-white rounded shadow-sm stat-card-custom position-relative hover-effect">
            <div class="d-flex justify-content-between">
                <div class="p-3 mb-3 card-icon-bg rounded-circle bg-info bg-opacity-10">
                    <i class="fas fa-star text-info fa-2x"></i>
                </div>
                <a href="" class="text-muted" title="View Ratings">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <div class="mb-2 text-muted">Average Rating</div>
            <div class="mb-0 h3">5 <span class="h6">/ 5</span></div>
        </div>
    </div>
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
