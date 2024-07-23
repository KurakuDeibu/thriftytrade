<!-- CONTENT -->
<div class="col-lg-9">
    <main>
        <h2 class="mb-4"><strong>Featured Items</strong></h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            @foreach ($featuredProducts as $products)

            <div class="col">
                <div class="card h-100 item-card">
                    <img src="https://placehold.co/600x400" alt="Vintage Lamp" class="card-img-top item-image">
                    <div class="card-body">
                        <h5 class="card-title item-title">{{$products->title}}</h5>
                        <p class="card-text item-price">₱{{$products->price}}</p>
                        @guest
                            <a href="/login" class="btn btn-outline-primary btn-sm">Login to View</a>
                        @endguest
                    </div>
                </div>
            </div>
            
            @endforeach

        </div>
    </main>
</div>

<!-- END OF CONTENT -->
