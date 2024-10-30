<!-- CONTENT -->
<main>
    <div class="mb-4 row">

        <div class="col-lg-12">
            <a href="/marketplace/product/{{ $products->id }}">
                <div class="bg-transparent card h-100 item-card">
                    <img src="{{ asset('storage/' . $products->prodImage) }}" alt="{{ $products->prodName }}"
                        class="card-img-top item-image">
                    @if ($products->featured == true)
                        <div class="top-0 m-2 text-white badge position-absolute end-0 bg-primary">Featured</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title item-title">{{ Str::limit($products->prodName, 15, '...') }}</h5>
                        <p class="card-text item-price">₱{{ $products->prodPrice }}</p>

                        {{-- Optional Button for Guests --}}
                        {{-- @guest
                                    <a href="/login" class="btn btn-outline-primary btn-sm">Login to View</a>
                                @endguest --}}
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>
<!-- END OF CONTENT -->
