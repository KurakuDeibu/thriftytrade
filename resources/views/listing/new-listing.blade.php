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
</style>
</head>

<body>

    @extends('layouts.app')

    @section('content')

        <!-- CONTENT -->

        <div class="container">
            <div class="form-container">
              <h1 class="py-4 fw-bold">Create New Listing</h1>

                <form action="/submit-listing" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-md-5">
                            <div class="mb-3">
                                <label for="images" class="form-label">Upload Images</label>
                                <input type="file" class="form-control" id="images" name="images" accept="image/*"
                                    multiple="" onchange="previewImages(this)">
                                <small class="form-text text-muted">You can upload up to 5 images. First image will be the
                                    main
                                    image.</small>
                            </div>
                            <div id="image-preview" class="mt-3 form-container ">
                                <!-- Image previews will be displayed here -->
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="mb-3">
                                <label for="title" class="form-label">Product Name: </label>
                                <input type="text" class="form-control" id="title" name="title" required="">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required="">
                                    <option value="">Select a category</option>
                                    <option value="wantabuyer">Want a Buyer</option>
                                    <option value="wantaseller">Want a Seller</option>
                                    <option value="featured">Featured</option>
                                    <option value="vehicles">Vehicles</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Product Description: </label>
                                <textarea class="form-control" id="description" name="description" rows="4" required=""></textarea>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="price" class="form-label">Price (₱)</label>
                                    <input type="number" class="form-control" id="price" name="price" min="0"
                                        step="0.01" required="">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="condition" class="form-label">Condition</label>
                                    <select class="form-select" id="condition" name="condition" required="">
                                        <option value="">Select condition</option>
                                        <option value="new">New</option>
                                        <option value="like-new">Likely New</option>
                                        <option value="good">Used</option>
                                        <option value="fair">Likely Used</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required="">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agreeTerms" required="">
                                <label class="form-check-label" for="agreeTerms">I agree to the <a href="/terms-of-service">Terms
                                        of Service</a> and
                                    <a href="/privacy-policy">Privacy Policy</a></label>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Listing</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    <script>
        // Bootstrap JS
        var bootstrapJS = document.createElement('script');
        bootstrapJS.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
        document.body.appendChild(bootstrapJS);

        // Image preview function
        function previewImages(input) {
            var preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            if (input.files) {
                [].forEach.call(input.files, function(file) {
                    if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                        var reader = new FileReader();
                        reader.addEventListener("load", function() {
                            var image = new Image();
                            image.height = 100;
                            image.title = file.name;
                            image.src = this.result;
                            preview.appendChild(image);
                        }, false);
                        reader.readAsDataURL(file);
                    }
                });
            }
        }
    </script>
