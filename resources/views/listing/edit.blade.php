<style>
    .form-container {
        max-width: 100%;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .image-container {
        margin-bottom: 2rem;
    }

    .image-container img {
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }

        .image-container {
            margin-bottom: 1.5rem;
        }

        .image-container img {
            max-height: 300px;
        }
    }

    @media (max-width: 576px) {
        .form-container {
            margin: 1rem auto;
        }
    }

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

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-container">
            <h1 class="mb-4 fw-bold">Edit Listing</h1>

            <form action="{{ route('listing.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">

                <!-- Make the layout more responsive using Bootstrap grid system -->
                <div class="row g-4">
                    <!-- Image Section -->
                    <div class="col-12 col-lg-5">
                        <div class="image-container">
                            <div class="image-container">
                                <label for="images">Image:</label>
                                <input type="file" class="mb-3 form-control" id="images" name="images"
                                    onchange="previewImage(this)">

                                @if ($product->prodImage)
                                    <img src="{{ asset('storage/' . $product->prodImage) }}" alt="Product Image"
                                        class="img-fluid" id="current-image">
                                @endif

                                @error('images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <div id="image-preview" class="image-preview">
                                    <span class="placeholder-text"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-12 col-lg-7">
                        <div class="row g-3" id="listing-form-wrapper">

                            <!-- Looking For Switch -->
                            <div class="mb-3 col-12 d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <label for="name" class="form-label">Listing Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $product->prodName }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mt-4 ms-2 d-flex align-items-center">
                                    <div class="form-check form-switch me-2">
                                        <input class="form-check-input" type="checkbox" id="is_looking_for"
                                            name="is_looking_for" value="1"
                                            {{ $product->is_looking_for ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_looking_for">
                                            Looking For
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Finders Fee Section (Conditionally Shown) -->
                            <div class="col-md-12" id="finders-fee-section"
                                style="{{ $product->is_looking_for ? 'max-height: 500px; opacity: 1; padding: 15px;' : '' }}">
                                <div class="card border-primary">
                                    <div
                                        class="card-header bg-primary text-dark d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Commission Fee Details</h5>
                                        <small class="text-muted">Optional</small>
                                    </div>
                                    <div class="card-body">
                                        <label for="finders_fee" class="form-label">Finders Fee (₱)</label>
                                        <input type="number" class="form-control" id="finders_fee" name="finders_fee"
                                            min="0" step="0.01" value="{{ $product->finders_fee }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="10">{{ $product->prodDescription }}</textarea>
                            </div>

                            <!-- Category -->
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->categName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label for="condition" class="form-label">Condition</label>
                                    <select class="form-select" id="condition" name="condition">
                                        <option value="New" {{ $product->prodCondition == 'New' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="Likely-New"
                                            {{ $product->prodCondition == 'Likely-New' ? 'selected' : '' }}>Likely-New
                                        </option>
                                        <option value="Used" {{ $product->prodCondition == 'Used' ? 'selected' : '' }}>
                                            Used
                                        </option>
                                        <option value="Likely-Used"
                                            {{ $product->prodCondition == 'Likely-Used' ? 'selected' : '' }}>Likely-Used
                                        </option>
                                    </select>
                                    @error('condition')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Price , Quantity, and Price Type-->
                                <div class="col-12 col-sm-6">
                                    <label for="price" class="form-label">Price (₱)</label>
                                    <input type="number" class="form-control" id="price" name="price" min="0"
                                        step="0.01" value="{{ $product->prodPrice }}">
                                </div>
                                <div class="col-12 col-sm-2">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        min="0" step="1" value="{{ $product->prodQuantity }}">
                                </div>

                                <div class="col-12 col-sm-4">
                                    {{-- CHANGE THIS INTO PRICE TYPE INSTEAD OF STATUS --}}
                                    <label for="price_type" class="form-label">Price Type</label>
                                    <select class="form-select" id="price_type" name="price_type">
                                        <option value="{{ \App\Models\Products::PRICE_TYPE_FIXED }}"
                                            {{ $product->price_type == 'Fixed' ? 'selected' : '' }}>Fixed
                                        </option>
                                        <option value="{{ \App\Models\Products::PRICE_TYPE_NEGOTIABLE }}"
                                            {{ $product->price_type == 'Negotiable' ? 'selected' : '' }}>Negotiable
                                        </option>
                                    </select>
                                    @error('price_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-sm-12">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-select @error('location') is-invalid @enderror" id="location"
                                        name="location">
                                        <option value="">Select Location</option>
                                        <option value="Lapu-Lapu City"
                                            {{ $product->location == 'Lapu-Lapu City' ? 'selected' : '' }}>
                                            Lapu-Lapu City
                                        </option>
                                        <option value="Mandaue City"
                                            {{ $product->location == 'Mandaue City' ? 'selected' : '' }}>
                                            Mandaue City
                                        </option>
                                    </select>
                                    @error('location')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-100">Update Listing</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.partials.footer-top')

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const currentImage = document.getElementById('current-image');


            preview.innerHTML = '';

            if (currentImage) {
                currentImage.style.display = 'none';
            }

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid');
                    preview.appendChild(img);
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '<span class="placeholder-text">Image preview will appear here</span>';
            }
        }

        // Toggle Finders Fee section based on Looking For checkbox
        document.getElementById('is_looking_for').addEventListener('change', function() {
            const findersFeeSection = document.getElementById('finders-fee-section');
            const listingFormWrapper = document.getElementById('listing-form-wrapper');

            if (this.checked) {
                findersFeeSection.classList.add('active');
            } else {
                findersFeeSection.classList.remove('active');
            }

            // Add/remove warning border to the form wrapper
            if (this.checked) {
                listingFormWrapper.classList.add('border', 'border-primary', 'p-3', 'rounded');
            } else {
                listingFormWrapper.classList.remove('border', 'border-primary', 'p-3', 'rounded');
            }
        });
    </script>
@endsection
