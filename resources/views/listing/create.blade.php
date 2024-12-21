@extends('layouts.app')

<link href="{{ asset('css/listings-styles.css') }}" rel="stylesheet">
<style>
    #finders-fee-section {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: 0.5s ease-in-out;
        padding: 0;
    }

    #finders-fee-section.active {
        max-height: 500px;
        opacity: 1;
        padding: 15px;
    }
</style>

@section('content')
    <div class="container">
        <div class="form-container">
            <h1 class="mb-4 fw-bold">Create New Listing</h1>

            @if (Auth::check() && !Auth::user()->hasVerifiedEmail())
                <div class="alert alert-danger" role="alert">
                    You must verify your email address before you can sell products.
                </div>
            @else
                <form action="{{ route('listing.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Image Upload Section -->
                        <div class="mb-4 col-12 col-lg-5 mb-lg-0">
                            <div class="image-preview-container">
                                <label for="images" class="form-label">Upload image <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror"
                                    id="images" name="images" accept="images" onchange="previewImage(this)">
                                <small class="mt-1 form-text text-muted d-block">Upload a clear image of your
                                    product</small>
                                @error('images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div id="image-preview" class="image-preview">
                                    <span class="placeholder-text">Image preview will appear here</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details Section -->
                        <div class="col-12 col-lg-7" id="listing-form-container">
                            <div class="row g-3" id="listing-form-wrapper">
                                <!-- Product Name -->
                                <div class="col-12 d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <label for="name" class="form-label">Listing Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mt-4 ms-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_looking_for"
                                                name="is_looking_for" value="1"
                                                {{ old('is_looking_for') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_looking_for" data-bs-toggle="tooltip"
                                                title="Toggle to apply commission listing">
                                                Looking For
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Finders Fee Section (Conditionally Shown) -->
                                <div class="col-12" id="finders-fee-section" style="display: none;">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-dark">
                                            <h5 class="mb-0">Commission Fee Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-3 col-12 col-md-12">
                                                    <label for="finders_fee" class="form-label">
                                                        Finders Fee (₱)
                                                        <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip"
                                                            title="The amount you're willing to pay to someone who helps you find the product your looking for"></i>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₱</span>
                                                        <input type="number" class="form-control" id="finders_fee"
                                                            name="finders_fee" min="0" step="0.01"
                                                            placeholder="Enter finders fee amount"
                                                            value="{{ old('finders_fee') }}">
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Optional: Set a finder's fee for the commission listing
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label"> Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="10">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-12 col-sm-6">
                                    <label for="category" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" id="category"
                                        name="category_id">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->categName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Condition -->
                                <div class="col-12 col-sm-6">
                                    <label for="condition" class="form-label">Condition <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('condition') is-invalid @enderror" id="condition"
                                        name="condition">
                                        <option value="">Select condition</option>
                                        @foreach (['New', 'Likely-New', 'Used', 'Likely-Used'] as $conditionOption)
                                            <option value="{{ $conditionOption }}"
                                                {{ old('condition') == $conditionOption ? 'selected' : '' }}>
                                                {{ $conditionOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('condition')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div class="col-12 col-sm-6">
                                    <label for="price" class="form-label">Price (₱) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" min="0" step="0.01"
                                        value="{{ old('price') }}">
                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- QUANTITY --}}
                                {{-- <div class="col-12 col-sm-3">
                                    <label for="quantity" class="form-label">Quantity <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" min="0" step="1"
                                        value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> --}}

                                {{-- PRICE TYPE --}}
                                <div class="col-12 col-sm-6">
                                    <label for="price_type" class="form-label">Price Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('price_type') is-invalid @enderror" id="price_type"
                                        name="price_type" required>
                                        <option value="">Select price type</option>
                                        <option value="{{ \App\Models\Products::PRICE_TYPE_FIXED }}"
                                            {{ old('price_type') == \App\Models\Products::PRICE_TYPE_FIXED ? 'selected' : '' }}>
                                            Fixed</option>
                                        <option value="{{ \App\Models\Products::PRICE_TYPE_NEGOTIABLE }}"
                                            {{ old('price_type') == \App\Models\Products::PRICE_TYPE_NEGOTIABLE ? 'selected' : '' }}>
                                            Negotiable</option>
                                    </select>
                                    @error('price_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- LOCATION --}}
                                <div class="mb-2 col-12 col-sm-12">
                                    <label for="location" class="form-label">Location <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('location') is-invalid @enderror" id="location"
                                        name="location">
                                        <option value="">Select Location</option>
                                        <option value="Lapu-Lapu City"
                                            {{ old('location') == 'Lapu-Lapu City' ? 'selected' : '' }}>
                                            Lapu-Lapu City
                                        </option>
                                        <option value="Mandaue City"
                                            {{ old('location') == 'Mandaue City' ? 'selected' : '' }}>
                                            Mandaue City
                                        </option>
                                    </select>
                                    @error('location')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <!-- Submit Button -->
                                <div class="mt-4 col-12">
                                    <button type="submit" class="btn btn-primary w-100">Create Listing</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = ''; // Clear previous content

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '<span class="placeholder-text">Image preview will appear here</span>';
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lookingForCheckbox = document.getElementById('is_looking_for');
            const nameInput = document.getElementById('name');
            const descriptionTextarea = document.getElementById('description');
            const priceInput = document.getElementById('price');
            const findersFeeSection = document.getElementById('finders-fee-section');
            const listingFormWrapper = document.getElementById('listing-form-wrapper');
            const findersFeeInput = document.getElementById('finders_fee');

            function toggleLookingForDetails() {
                const isChecked = lookingForCheckbox.checked;

                findersFeeSection.style.display = isChecked ? 'block' : 'none';

                // Toggle finders fee section visibility with animation
                if (isChecked) {
                    findersFeeSection.classList.add('active');
                } else {
                    findersFeeSection.classList.remove('active');
                }

                // Update placeholders based on checkbox state
                if (isChecked) {
                    nameInput.setAttribute('placeholder', 'What item are you looking for?');
                    descriptionTextarea.setAttribute('placeholder',
                        'Provide detailed information about the specific item you\'re seeking. Include specifications, model, or any other relevant details that will help potential finder\'s understand exactly what you\'re looking for.'
                    );
                    priceInput.setAttribute('placeholder', 'Maximum price you\'ll pay for the item');
                } else {
                    nameInput.setAttribute('placeholder', '');
                    descriptionTextarea.setAttribute('placeholder', '');
                    priceInput.setAttribute('placeholder', '');
                }

                // Add/remove warning border to the form wrapper
                if (isChecked) {
                    listingFormWrapper.classList.add('border', 'border-primary', 'p-3', 'rounded');
                } else {
                    listingFormWrapper.classList.remove('border', 'border-primary', 'p-3', 'rounded');
                }


                // Require finders fee input if checkbox is checked
                findersFeeInput.required = isChecked;
            }

            // Initial state
            toggleLookingForDetails();

            // Event listeners
            lookingForCheckbox.addEventListener('change', toggleLookingForDetails);

        });
    </script>


    <script src="{{ asset('js/listings-validation.js') }}"></script>

    @include('layouts.partials.footer-top')

@endsection
