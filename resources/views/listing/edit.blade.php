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
</style>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-container">
            <h1 class="py-4 fw-bold">Edit Listing</h1>

            <form action="{{ route('listing.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">

                <!-- Make the layout more responsive using Bootstrap grid system -->
                <div class="row g-4">
                    <!-- Image Section -->
                    <div class="col-12 col-lg-5">
                        <div class="image-container">
                            <label for="images">Image:</label>
                            @if ($product->prodImage)
                                <input type="file" class="mb-3 form-control" id="images" name="images">
                                <img src="{{ asset('storage/' . $product->prodImage) }}" alt="Product Image"
                                    class="img-fluid">
                            @else
                                <input type="file" class="mb-3 form-control" id="images" name="images">
                            @endif
                            @error('images')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-12 col-lg-7">
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="prodName" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" id="prodName" name="name"
                                value="{{ $product->prodName }}">
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
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
                        {{-- @dd($product->category->category_id) --}}

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ $product->prodDescription }}</textarea>
                        </div>

                        <!-- Price and Condition -->
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="price" class="form-label">Price (₱)</label>
                                <input type="number" class="form-control" id="price" name="price" min="0"
                                    step="0.01" value="{{ $product->prodPrice }}">
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="condition" class="form-label">Condition</label>
                                <select class="form-select" id="condition" name="condition">
                                    <option value="New" {{ $product->prodCondition == 'New' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="Likely-New"
                                        {{ $product->prodCondition == 'Likely-New' ? 'selected' : '' }}>Likely-New</option>
                                    <option value="Used" {{ $product->prodCondition == 'Used' ? 'selected' : '' }}>Used
                                    </option>
                                    <option value="Likely-Used"
                                        {{ $product->prodCondition == 'Likely-Used' ? 'selected' : '' }}>Likely-Used
                                    </option>
                                </select>
                                @error('condition')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100">Update Listing</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection