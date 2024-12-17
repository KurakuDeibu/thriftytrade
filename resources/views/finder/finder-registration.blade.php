{{-- resources/views/finder/finder-registration.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><small><a href="{{ url('/') }}">Home</a></small></li>
                <li class="breadcrumb-item active"><small><a href="{{ url('marketplace') }}">Marketplace</a></small></li>
                </li>
            </ol>
        </nav>
        <div class="container flex flex-col py-5 mx-auto md:flex-row">
            <!-- Form Section -->

            <div class="p-6 bg-white rounded-lg shadow-md md:w-1/2">
                <h2 class="mb-4 text-2xl font-bold text-center">BECOME A FINDER!</h2>

                @if (session('error'))
                    <div class="p-3 mb-4 text-white bg-red-500 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="p-3 mb-4 text-white bg-green-500 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('finder.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="finder_document" class="block text-sm font-medium text-gray-700">Upload Valid ID
                            Document</label>
                        <div class="p-4 mt-1 border-2 border-gray-300 border-dashed rounded-lg">
                            <input type="file" name="finder_document" id="finder_document" class="hidden"
                                accept="image/*,application/pdf" onchange="previewImage(event)" required>
                            <label for="finder_document"
                                class="flex flex-col items-center justify-center h-full cursor-pointer">
                                <span class="text-gray-500">Drag and drop your file here or click to upload</span>
                                <span class="text-sm text-gray-400">Accepted formats: PDF, JPG, JPEG, PNG (Max 5MB)</span>
                            </label>
                            <div id="image-preview" class="hidden mt-4">
                                <img id="preview" src="" alt="Image Preview" class="rounded-md shadow-md" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="additional_notes" class="block text-sm font-medium text-gray-700">Additional Notes
                            (Optional)</label>
                        <textarea name="additional_notes" id="additional_notes"
                            class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500"
                            rows="3"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-2 font-semibold text-white transition duration-200 bg-blue-600 rounded-md hover:bg-blue-700">Submit
                        Finder Request</button>
                </form>
            </div>

            <!-- Information Section -->
            <div class="p-6 mt-6 bg-gray-100 rounded-lg shadow-md md:w-1/2 md:ml-4 md:mt-0">
                <h3 class="mb-2 text-xl font-bold">Why Become a Finder?</h3>
                <p class="mb-4 text-gray-700">As a Finder, you help users locate products, items, cars, phones, and more for
                    a
                    finder's fee. Here are some benefits:</p>
                <ul class="mb-4 list-disc list-inside">
                    <li class="mb-2">🔍 Access to exclusive finder opportunities.</li>
                    <li class="mb-2">🤝 Connect with a community of like-minded individuals.</li>
                    <li class="mb-2">🏆 Earn a finder's fee for successful finds.</li>
                    <li class="mb-2">📈 Enhance your reputation as a trusted finder.</li>
                </ul>
                <p class="text-gray-700">Join us in helping others find what they need!</p>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @include('layouts.partials.footer-top')
@endsection
