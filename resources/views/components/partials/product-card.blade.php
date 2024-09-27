<!-- CONTENT -->
<div class="col-lg-9">
    <main>
        <h2 class="mb-4"><strong>Featured Items</strong></h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            @foreach ($featuredProducts as $products)
                <div class="col">
                    <a wire:navigate href="/marketplace/product/{{ $products->id }}">
                        <div class="card h-100 item-card">
                            <img src="{{ asset('storage/' . $products->prodImage ) }}" alt="{{ $products->prodName }}" class="card-img-top item-image">
                            <div class="card-body">
                                <h5 class="card-title item-title">{{ $products->prodName }}</h5>
                                <p class="card-text item-price">₱{{ $products->prodPrice }}</p>

                                {{-- @guest
                                    <a href="/login" class="btn btn-outline-primary btn-sm">Login to View</a>
                                @endguest --}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            </div>
            <a class="block mt-4 text-lg text-center" href="{{route('marketplace')}}"><div class="btn btn-outline-primary">More Featured</div></a>

        </div>

    </main>

</div>

<!-- END OF CONTENT -->
