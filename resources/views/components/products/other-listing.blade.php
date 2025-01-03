 {{-- OTHER LISTINGS OF THE USER --}}
 <div class="mb-3 row">
     <div class="col-12 d-flex justify-content-between align-items-center">
         <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}"
             class="mt-5 text-xl font-bold text-center">
             Other listings by <span
                 class="text-blue-500 hover-underline">{{ $marketplaceProducts->author->name }}</span>
         </a>
         @if ($hasOtherListings && $showOtherListings->count() > 4)
             <a href="{{ route('profile.user-listing', $marketplaceProducts->author->id) }}"
                 class="font-medium text-blue-500 hover-underline">Show All</a>
         @endif
     </div>
 </div>
 <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
     @if ($hasOtherListings)
         @foreach ($showOtherListings as $product)
             <div class="col">
                 <a href="/marketplace/product/{{ $product->id }}" class="card h-100 text-decoration-none text-dark">
                     <img src="{{ $product->prodImage && file_exists(public_path('storage/' . $product->prodImage))
                         ? asset('storage/' . $product->prodImage)
                         : asset('img/NOIMG.jpg') }}"
                         class="card-img-top fixed-image" alt="{{ $product->prodName }}">

                     <div class="card-body">
                         <h5 class="card-title">{{ Str::limit($product->prodName, 40, '...') }}</h5>
                         <p class="card-text">₱{{ $product->prodPrice }}</p>
                     </div>
                 </a>
             </div>
         @endforeach
     @else
         <p class="text-center alert alert-primary w-100">No other listings available from this user.
         </p>
     @endif
 </div>
