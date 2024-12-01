{{-- LIVEWIRE-SEARCH --}}
{{-- Hero Section Search --}}
<div x-data="{ query: @entangle('query').live }" id="search-box" class="px-2 col-lg-9">
    <div class="px-4 py-4 hero-section card">
        <h1 class="mb-1 text-white display-6">THRIFT&TRADE IN YOUR LOCAL AREAS!</h1>
        <div class="mt-2">
            <div class="d-flex">
                <input x-model="query" wire:model.live="query" wire:keydown.enter="search"
                    class="py-2 form-control rounded-5 me-2" type="text" placeholder="What are you looking for?...">
                <button wire:click="search" class="btn btn-primary">
                    <i class="bi bi-search"></i> <!-- Search icon -->
                </button>
                {{-- Clear Search Button --}}
                <button x-show="query" @click="query = ''" class="btn btn-secondary ms-2">
                    <i class="bi bi-x-circle"></i> <!-- Clear icon -->
                </button>
            </div>
        </div>
    </div>


    {{-- SHOW ACTIVE FILTERS --}}
    @if (!empty($activeFilters))
        <div class="mt-3 mb-3 col-12">
            <div class="alert alert-primary d-flex justify-content-between align-items-center">
                <span class="fw-bold">Your Active Filters:</span>
                <div class="flex-wrap gap-2 d-flex">
                    @foreach ($activeFilters as $key => $filter)
                        <div class="badge bg-primary d-flex align-items-center" style="font-size: 0.9rem;">
                            <span class="me-2">{{ $filter['name'] }}</span>
                            <a wire:click="removeFilter('{{ $filter['type'] }}')" class="text-white"
                                style="text-decoration: none; margin-left: 5px; cursor: pointer;">
                                <i class="bi bi-x-circle-fill"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    {{-- Search Results --}}
    <div class="my-3 text-center justify-content-between align-items-center">
        {{-- Loading Indicator --}}
        <div wire:loading class="p-5 my-5 mt-5 text-center justify-content-between align-items-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <i class="text-primary fs-2 animate__animated animate__shakeX animate__infinite"
                style="animation-duration: 0.5s;"></i>
            <p class="mt-2 text-muted">Searching...</p>
        </div>
    </div>

    {{-- Search Results --}}
    <div wire:loading.remove>
        @if ($marketplaceProducts->count() > 0)
            <div class="py-2 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($marketplaceProducts as $products)
                    <x-products.content-card :products="$products" />
                @endforeach
            </div>
        @else
            <div class="p-4 text-center d-flex flex-column justify-content-center align-items-center">
                <div class="mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                        class="bi bi-search text-muted" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </div>
                <h2 class="mb-3 text-muted">No Listings Found</h2>
                <p class="mb-4 text-muted">
                    We couldn't find any listing matching your search or filter criteria.
                </p>

                <div class="gap-3 d-flex">
                    <a href="{{ route('marketplace') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                    </a>
                    <a href="{{ route('listing.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create New Listing
                    </a>
                </div>

                @if (!empty($activeFilters))
                    <div class="mt-4">
                        <h5 class="mb-3 text-muted">Your Current Filters:</h5>
                        <div class="flex-wrap gap-2 d-flex justify-content-center">
                            @foreach ($activeFilters as $key => $filter)
                                <span class="badge bg-secondary">
                                    {{ $filter['name'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    {{-- Pagination --}}
    <div class="mt-5">
        {{ $marketplaceProducts->onEachSide(1)->links() }}
    </div>
</div>
