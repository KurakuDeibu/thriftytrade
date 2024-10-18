<!-- CONTENT -->
<div class="col-lg-9">
    <main>
        <h2 class="mb-2"><strong>Featured Products</strong></h2>
        <div class="mb-4 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            @foreach ($featuredProducts as $product)
                <div class="col">
                    <a href="/marketplace/product/{{ $product->id }}">
                        <div class="card h-100 item-card bg-success">
                            <img src="{{ asset('storage/' . $product->prodImage) }}" alt="{{ $product->prodName }}"
                                class="card-img-top item-image">
                            <div class="top-0 m-2 text-white badge position-absolute end-0 bg-primary">Featured</div>
                            <div class="card-body">
                                <h5 class="card-title item-title">{{ $product->prodName }}</h5>
                                <p class="card-text item-price">₱{{ $product->prodPrice }}</p>

                                {{-- Optional Button for Guests --}}
                                {{-- @guest
                                    <a href="/login" class="btn btn-outline-primary btn-sm">Login to View</a>
                                @endguest --}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
        <a class="block text-lg text-center" href="{{ route('marketplace') }}">
            <div class="btn btn-outline-primary">View More</div>
        </a>

    </main>
</div>
<!-- END OF CONTENT -->
