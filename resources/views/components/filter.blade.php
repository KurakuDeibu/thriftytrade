<!-- FILTER DIV -->
<div>
    <h4>Filters <i class="bis bi-filter"></i></h4>
    <form>
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <select id="location" class="form-select">
                <option value="">All Locations</option>
                <option value="local">Lapu-Lapu City</option>
                <option value="city">Mandaue City</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select wire:model="category" class="form-select">
                <option value="">Select a category...</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->category_id }}">{{ $category->categName }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="condition" class="form-label">Condition:</label>
            <select id="condition" class="form-select">
                <option value="">Any Condition</option>
                <option value="new">New</option>
                <option value="like-new">Likely New</option>
                <option value="good">Used</option>
                <option value="fair">Likely Used</option>
            </select>
        </div>

        <button type="submit" class="btn btn-outline-primary w-100">Apply Filters</button>
    </form>
</div>
<!-- END OF FILTER-DIV -->
