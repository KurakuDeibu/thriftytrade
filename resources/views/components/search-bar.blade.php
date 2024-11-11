<style>
    .hero-section {
        background: linear-gradient(rgba(11, 66, 177, 0.8), rgba(66, 103, 178, 0.9)), url('img/hero-img.png');
        background-size: cover;
        color: white;
        padding: 60px 0;
        margin-bottom: 15px;
    }
</style>
<!-- SEARCH-BAR -->
<div class="px-2 col-lg-9">
    <div class="px-4 py-4 hero-section card">
        <h1 class="mb-1 display-6"> THRIFT&TRADE PRODUCTS IN YOUR LOCAL AREAS!</h1>
        <div class="mt-2">
            <form class="d-flex search-form" action="{{ route('marketplace') }}" method="GET">
                <input class="py-2 rounded-lg form-control me-2" type="text" name="query" id="query"
                    value="{{ request()->input('query') }}" placeholder="Search Listings..." aria-label="Search">

                <!-- Hidden inputs for preserving current filters -->
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                @if (request('condition'))
                    <input type="hidden" name="condition" value="{{ request('condition') }}">
                @endif

                @if (request('featured'))
                    <input type="hidden" name="featured" value="{{ request('featured') }}">
                @endif

                @if (request('featured'))
                    <input type="hidden" name="featured" value="{{ request('featured') }}">
                @endif
                <button class="btn btn-light" type="submit">Search</button>
            </form>
            @include('marketplace.search-results')
        </div>
    </div>
