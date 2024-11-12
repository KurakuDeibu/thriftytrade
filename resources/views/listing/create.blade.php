@extends('layouts.app')

<link href="{{ asset('css/listings-styles.css') }}" rel="stylesheet">

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
                                <label for="images" class="form-label">Upload image</label>
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
                        <div class="col-12 col-lg-7">
                            <div class="row g-3">
                                <!-- Product Name -->
                                <div class="col-12">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-12 col-sm-6">
                                    <label for="category" class="form-label">Category</label>
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

                                <div class="col-12 col-sm-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status_id') is-invalid @enderror" id="status"
                                        name="status_id">
                                        <option value="">Select a status</option>
                                        @foreach ($stats as $status)
                                            <option value="{{ $status->id }}"
                                                {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->statusName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label">Product Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div class="col-12 col-sm-3">
                                    <label for="price" class="form-label">Price (₱)</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        id="price" name="price" min="0" step="0.01"
                                        value="{{ old('price') }}">
                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 col-sm-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" min="0" step="1"
                                        value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Condition -->
                                <div class="col-12 col-sm-6">
                                    <label for="condition" class="form-label">Condition</label>
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

    <script src="{{ asset('js/listings-validation.js') }}"></script>
@endsection
