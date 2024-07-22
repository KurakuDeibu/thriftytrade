<!-- FILTER DIV -->
<div>
    <h4>Filters <i class="bis bi-filter"></i></h4>
    <form>
        <div class="mb-3">
            <label for="location" class="form-label">Location:</label>
            <select id="location" class="form-select">
                <option value="">All Locations</option>
                <option value="local">Local (within 5 miles)</option>
                <option value="city">City-wide</option>
                <option value="state">State-wide</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select id="category" class="form-select">
                <option value="">All Categories</option>
                <option value="furniture">Furniture</option>
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
                <option value="books">Books</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="condition" class="form-label">Condition:</label>
            <select id="condition" class="form-select">
                <option value="">Any Condition</option>
                <option value="new">New</option>
                <option value="like-new">Like New</option>
                <option value="good">Good</option>
                <option value="fair">Fair</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
    </form>
</div>
<!-- END OF FILTER-DIV -->
