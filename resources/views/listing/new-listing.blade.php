
<style>
    .navbar-brand {
        font-weight: bold;
        color: #4267B2 !important;
    }

    .form-container {
        max-width: 100%;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #4267B2;
        border-color: #4267B2;
    }

    .btn-primary:hover {
        background-color: #365899;
        border-color: #365899;
    }
    .image-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Set uniform size for image previews */
    .image-grid img {
        width: 100px;
        height: 100px;
        object-fit: cover; /* This will crop the image to fit within the set dimensions without stretching */
        border-radius: 8px; /* Optional: add rounded corners */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: add a slight shadow */
    }
</style>


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <h1 class="py-4 fw-bold">Create New Listing</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-5">
                    <label for="images" class="form-label">Upload Images</label>
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required onchange="previewImages(this)">
                    <small class="form-text text-muted">You can upload up to 5 images. First image will be the main image.</small>
                    <p id="image-count" class="text-muted">0 images selected.</p>
                    <div id="image-preview" class="mt-3 form-container image-grid"></div>
                    <ul id="image-file-list" class="list-unstyled mt-3"></ul>
                </div>

                <div class="col-md-7">
                    <div class="mb-3">
                        <label for="title" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->categName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Product Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="price" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="condition" class="form-label">Condition</label>
                            <select class="form-select" id="condition" name="condition" required>
                                <option value="">Select condition</option>
                                <option value="new">New</option>
                                <option value="like-new">Likely New</option>
                                <option value="good">Used</option>
                                <option value="fair">Likely Used</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create Listing</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImages(input) {
        var preview = document.getElementById('image-preview');
        var fileList = document.getElementById('image-file-list');
        var imageCount = document.getElementById('image-count');
        preview.innerHTML = ''; 
        fileList.innerHTML = ''; 

        if (input.files) {
            if (input.files.length > 5) {
                alert('You can only upload up to 5 images.');
                input.value = ''; 
                imageCount.textContent = '0 images selected.';  
                return;
            }

            imageCount.textContent = `${input.files.length} images selected.`;

            [].forEach.call(input.files, function(file) {
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    var reader = new FileReader();
                    reader.addEventListener("load", function () {
                        var image = new Image();
                        image.height = 100;
                        image.title = file.name;
                        image.src = this.result;
                        preview.appendChild(image);
                    }, false);
                    reader.readAsDataURL(file);

                    var listItem = document.createElement('li');
                    listItem.textContent = file.name;
                    fileList.appendChild(listItem);
                }
            });
        }
    }
</script>
@endsection
