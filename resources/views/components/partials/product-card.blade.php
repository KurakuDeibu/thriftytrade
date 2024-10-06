<!-- CONTENT -->
<div class="col-lg-9">
    <main>
        <h2 class="mb-4"><strong>Featured Items</strong></h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            @foreach ($featuredProducts as $product)
                <div class="col">
                    <a wire:navigate href="/marketplace/product/{{ $product->id }}">
                        <div class="card h-100 item-card">
                            <img src="{{ asset('storage/' . $product->prodImage ) }}" alt="{{ $product->prodName }}" class="card-img-top item-image">
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
        <a class="block mt-4 text-lg text-center" href="{{ route('marketplace') }}">
            <div class="btn btn-outline-primary">View More</div>
        </a>

    </main>
</div>
<!-- END OF CONTENT -->
