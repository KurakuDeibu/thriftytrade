@props(['products'])

{{-- @auth --}}
    {{-- @if ($products->user_id == Auth::user()->id) --}}
        <div class="col">
            <a wire:navigate href="/marketplace/product/{{ $products->id }}">
                <div class="card h-100 item-card">
                    <img src="{{ asset('storage/' . $products->prodImage) }}" alt="{{ $products->prodName }}" class="card-img-top item-image">
                    <div class="card-body">
                        <h5 class="card-title item-title">{{ $products->prodName }}</h5>
                        <p class="card-text item-price">₱{{ $products->prodPrice }}</p>
                        {{-- <h5 class="mt-5 card-title"><a href="#"> Posted by: {{$products->author->name }} </a></h5> --}}

                    </div>
                </div>
            </a>
</div>

    {{-- @endif --}}
{{-- @endauth --}}
