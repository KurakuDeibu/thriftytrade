 {{-- RECOMMENDED LISTINGS FOR THE USER --}}
 @if ($similarListings->count() > 0)
     <div class="mt-5">
         <h3 class="mb-4 text-xl font-bold">Similar Listings</h3>
         <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
             @foreach ($similarListings->shuffle() as $similarProduct)
                 <div class="col">
                     <a href="/marketplace/product/{{ $similarProduct->id }}"
                         class="card h-100 text-decoration-none text-dark">
                         <img src="{{ $similarProduct->prodImage && file_exists(public_path('storage/' . $similarProduct->prodImage))
                             ? asset('storage/' . $similarProduct->prodImage)
                             : asset('img/NOIMG.jpg') }}"
                             class="card-img-top fixed-image" alt="{{ $similarProduct->prodName }}">
                         <div class="wishlist-icon">
                             <i class="far fa-heart"></i>
                         </div>
                         <div class="card-body">
                             <h5 class="card-title">
                                 {{ Str::limit($similarProduct->prodName, 40, '...') }}</h5>
                             <p class="card-text">₱{{ $similarProduct->prodPrice }}</p>
                         </div>
                     </a>
                 </div>
             @endforeach
         </div>
     </div>
 @endif
