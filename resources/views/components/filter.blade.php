<!-- FILTER DIV -->
<!-- Mobile Filter Toggle Button -->
<button class="mobile-filter-toggle btn btn-outline-primary" onclick="toggleMobileFilters()">
    <i class="bi bi-filter me-2"></i>Filters
</button>

<!-- Filter Content with Mobile Wrapper -->
<div class="filter-content">
    <div class="filter-mobile-header d-none">
        <h4>Filters</h4>
        <button class="filter-mobile-close" onclick="toggleMobileFilters()">
            <i class="bi bi-x"></i>
        </button>
    </div>

    <form id="marketplace-filter-form" action="{{ route('marketplace') }}" method="GET">

        <!-- Product Filters -->
        <div class="py-2 product-filter-group">
            <!-- Featured Products -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="featured" id="featured-products" value="1"
                    onchange="this.form.submit()" {{ request('featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="featured-products">
                    Show featured listings only
                </label>
            </div>

            @if (Auth::user()->isFinder)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_looking_for" id="is_looking_for-products"
                        value="1" onchange="this.form.submit()" {{ request('is_looking_for') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_looking_for-products">
                        Show looking for listings only
                    </label>
                </div>
            @endif
        </div>

        {{-- LISTING LOCATION BASE FILTER --}}
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <select id="location" name="location" class="form-select" onchange="this.form.submit()">
                <optgroup label="All Location">

                    <option value="">All Locations</option>
                    <option value="Lapu-Lapu City" {{ request('location') == 'Lapu-Lapu City' ? 'selected' : '' }}>
                        Lapu-Lapu City
                    </option>
                    <option value="Mandaue City" {{ request('location') == 'Mandaue City' ? 'selected' : '' }}>
                        Mandaue City
                    </option>
                </optgroup>
            </select>
        </div>



        {{-- CATEGORY CHECKBOX FILTER --}}
        {{-- CATEGORY CHECKBOX FILTER --}}
        <div class="mb-3">
            <label class="form-label">Categories</label>
            <div class="category-checkbox-group">
                @php
                    $categories = \App\Models\Category::all();
                    $totalProductCount = \App\Models\Products::count();
                @endphp

                @foreach ($categories as $category)
                    @php
                        $productCount = \App\Models\Products::where('category_id', $category->id)->count();
                    @endphp
                    <div class="form-check">
                        <input onchange="this.form.submit()" class="form-check-input" type="checkbox"
                            name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}"
                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category-{{ $category->id }}">
                            {{ $category->categName }} ({{ $productCount }})
                        </label>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="mb-3">
            <label for="condition" class="form-label">Condition:</label>
            <select id="condition" name="condition" onchange="this.form.submit()" class="form-select">
                <optgroup label="Condition">
                    <option value="">Any Condition</option>
                    <option value="New" {{ request('condition') == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Likely-New" {{ request('condition') == 'Likely-New' ? 'selected' : '' }}>Likely
                        New
                    </option>
                    <option value="Used" {{ request('condition') == 'Used' ? 'selected' : '' }}>Used</option>
                    <option value="Likely-Used" {{ request('condition') == 'Likely-Used' ? 'selected' : '' }}>
                        Likely
                        Used
                    </option>
                </optgroup>
            </select>
        </div>


        <div class="mb-3">
            <label for="price_type" class="form-label">Price Type:</label>
            <select id="price_type" name="price_type" onchange="this.form.submit()" class="form-select">
                <optgroup label="Price Type">
                    <option value="">Any Price Type</option>
                    <option value="Fixed" {{ request('price_type') == 'Fixed' ? 'selected' : '' }}>Fixed</option>
                    <option value="Negotiable" {{ request('price_type') == 'Negotiable' ? 'selected' : '' }}>Negotiable
                    </option>
                </optgroup>
            </select>
        </div>



        <label for="condition" class="form-label">Sort By: </label>
        <div class="row align-items-center">

            <div class="input-group" style="width: 250px;">
                <span class="bg-white input-group-text border-end-0">
                    <i class="bi bi-sort-down text-muted"></i>
                </span>

                <select name="sort" onchange="this.form.submit()" class="form-select border-start-0"
                    aria-label="Sort products">
                    <optgroup label="Date">
                        <option value="latest" {{ $sortBy == 'latest' ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="oldest" {{ $sortBy == 'oldest' ? 'selected' : '' }}>
                            Oldest First
                        </option>
                    </optgroup>
                    <optgroup label="Price">
                        <option value="price_low" {{ $sortBy == 'price_low' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="price_high" {{ $sortBy == 'price_high' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                    </optgroup>
                </select>
            </div>
        </div>
    </form>
</div>
<!-- END OF FILTER-DIV -->


<script>
    function toggleMobileFilters() {
        const filterContent = document.querySelector('.filter-content');
        const filterMobileHeader = document.querySelector('.filter-mobile-header');

        // Toggle visibility
        filterContent.classList.toggle('show');

        // Toggle mobile header visibility
        if (window.innerWidth <= 991.98) {
            filterMobileHeader.classList.toggle('d-none');

            // Prevent body scrolling
            if (filterContent.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
    }

    // Close filter when clicking outside
    document.addEventListener('click', function(event) {
        const filterContent = document.querySelector('.filter-content');
        const filterToggle = document.querySelector('.mobile-filter-toggle');
        const filterMobileHeader = document.querySelector('.filter-mobile-header');

        if (window.innerWidth <= 991.98 &&
            filterContent.classList.contains('show') &&
            !filterContent.contains(event.target) &&
            !filterToggle.contains(event.target)) {

            filterContent.classList.remove('show');
            filterMobileHeader.classList.add('d-none');
            document.body.style.overflow = 'auto';
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        const filterContent = document.querySelector('.filter-content');
        const filterMobileHeader = document.querySelector('.filter-mobile-header');

        if (event.key === 'Escape' &&
            window.innerWidth <= 991.98 &&
            filterContent.classList.contains('show')) {

            filterContent.classList.remove('show');
            filterMobileHeader.classList.add('d-none');
            document.body.style.overflow = 'auto';
        }
    });
</script>


<style>
    /* Mobile Filter Toggle */
    .mobile-filter-toggle {
        display: none;
    }

    @media (max-width: 991.98px) {
        .mobile-filter-toggle {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
        }

        .sidebar .filter-content {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 1050;
            overflow-y: auto;
            padding: 20px;
            animation: slideIn 0.3s ease-out;
        }

        .sidebar .filter-content.show {
            display: block;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .filter-mobile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-mobile-close {
            background: none;
            border: none;
            font-size: 1.5rem;
        }
    }

    .category-checkbox-group {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 4px;
    }

    .form-check {
        margin-bottom: 5px;
    }

    .form-check-input:checked {
        background-color: #4267B2;
        border-color: #4267B2;
    }
</style>
