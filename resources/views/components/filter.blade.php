<!-- FILTER DIV -->
<div>
    <h4>Filters <i class="bis bi-filter"></i></h4>
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
        </div>

        {{-- LISTING LOCATION BASE FILTER --}}
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <select id="location" name="location" class="form-select" onchange="this.form.submit()">
                <option value="">All Locations</option>
                <option value="local" {{ request('location') == 'local' ? 'selected' : '' }}>Lapu-Lapu City</option>
                <option value="city" {{ request('location') == 'city' ? 'selected' : '' }}>Mandaue City</option>
            </select>
        </div>



        {{-- CATEGORY RADIO FILTER --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <div class="category-radio-group">
                @php
                    $categories = \App\Models\Category::all();
                    $totalProductCount = \App\Models\Products::count();
                @endphp

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="category" id="category-all" value=""
                        onchange="this.form.submit()" {{ request('category') == '' ? 'checked' : '' }}>
                    <label class="form-check-label" for="category-all">
                        All Categories ({{ $totalProductCount }})
                    </label>
                </div>

                @foreach ($categories as $category)
                    @php
                        $productCount = \App\Models\Products::where('category_id', $category->id)->count();
                    @endphp
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" id="category-{{ $category->id }}"
                            value="{{ $category->id }}" onchange="this.form.submit()"
                            {{ request('category') == $category->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="category-{{ $category->id }}">
                            {{ $category->categName }} ({{ $productCount }})
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            .category-radio-group {
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



        <div class="mb-3">
            <label for="condition" class="form-label">Condition:</label>
            <select id="condition" name="condition" onchange="this.form.submit()" class="form-select">
                <optgroup label="Condition">
                    <option value="">Any Condition</option>
                    <option value="New" {{ request('condition') == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Likely-New" {{ request('condition') == 'Likely-New' ? 'selected' : '' }}>Likely New
                    </option>
                    <option value="Used" {{ request('condition') == 'Used' ? 'selected' : '' }}>Used</option>
                    <option value="Likely-Used" {{ request('condition') == 'Likely-Used' ? 'selected' : '' }}>Likely
                        Used
                    </option>
                </optgroup>
            </select>
        </div>

        {{-- <button type="submit" class="btn btn-outline-primary w-100">Apply Filters</button> --}}

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

<style>
    .input-group-text {
        background-color: transparent !important;
    }

    select optgroup {
        font-weight: bold;
        color: #4267B2;
    }

    select option {
        font-weight: normal;
        color: #333;
    }
</style>
