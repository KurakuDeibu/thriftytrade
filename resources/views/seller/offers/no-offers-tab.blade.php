<div class="tab-pane fade" id="no-offers" role="tabpanel" aria-labelledby="no-offers-tab">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Products without Offers</h5>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Listed Price</th>
                            <th>Date Listed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productsWithNoOffers as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->prodImage && file_exists(public_path('storage/' . $product->prodImage))
                                            ? asset('storage/' . $product->prodImage)
                                            : asset('img/NOIMG.jpg') }}"
                                            class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        <h4 class="mb-0">{{ Str::limit($product->prodName, 30) }}</h4>
                                    </div>
                                </td>
                                <td>₱{{ number_format($product->prodPrice, 2) }}</td>
                                <td>{{ $product->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a type="button" href="/marketplace/product/{{ $product->id }}"
                                        class="btn btn-sm btn-outline-primary bi bi-eye"></a>
                                    <a type="button" href="{{ route('listing.edit', $product->id) }}"
                                        class="btn btn-sm btn-outline-primary bi bi-pencil"></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
