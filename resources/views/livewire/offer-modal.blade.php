<div>
    <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true"
        wire:ignore.self x-data="offerModalFocus()">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="border-0 modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-0 modal-body">
                    <div class="row g-0">
                        <!-- Product Details (Left Side) -->
                        <div class="p-4 col-md-5 bg-light"
                            style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
                            <div class="product-preview">
                                <div class="mb-3 product-image-container">
                                    <img src="{{ $product->prodImage && file_exists(public_path('storage/' . $product->prodImage))
                                        ? asset('storage/' . $product->prodImage)
                                        : asset('img/NOIMG.jpg') }}"
                                        class="product-image">
                                </div>

                                <!-- Seller Info -->
                                <div class="mb-3 seller-info">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->author->profile_photo_url }}"
                                            alt="{{ $product->author->name }}" class="seller-avatar">
                                        <div class="ms-2">
                                            <p class="mb-0 fw-bold">{{ $product->author->name }}</p>
                                            <small class="text-muted">Seller</small>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-2 product-title">{{ $product->prodName }}</h5>
                                <p class="mb-2 price">₱{{ number_format($product->prodPrice, 2) }}</p>
                                <p class="mb-2 small">{{ $product->category->categName }} •
                                    {{ $product->prodCondition }}</p>
                            </div>
                        </div>

                        <!-- Offer Form (Right Side) -->
                        <div class="p-4 bg-white col-md-7">
                            <h5 class="mb-4 text-primary">Make Your Offer</h5>
                            <form wire:submit.prevent="submitOffer">
                                <div class="mb-3">
                                    <label for="offerPrice" class="form-label">
                                        @if ($product->price_type == 'Fixed')
                                            Fixed Price
                                        @else
                                            Your Price
                                        @endif
                                    </label>
                                    <div class="input-group">
                                        <span class="text-white border-0 input-group-text bg-primary">₱</span>
                                        <input type="number" class="form-control" id="offerPrice"
                                            x-ref="offerPriceInput" wire:model.defer="offerPrice"
                                            @if ($product->price_type == 'Fixed') readonly
                                                   value="{{ $product->prodPrice }}"
                                               @else
                                                   min="1"
                                                   step="0.01"
                                                   placeholder="{{ $product->prodPrice }}" @endif>
                                    </div>
                                    @if ($product->price_type == 'Fixed')
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            This is a fixed-price item. The offer price cannot be changed.
                                        </small>
                                    @endif
                                    @error('offerPrice')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meetupLocation" class="form-label">Meetup Location</label>
                                    <input type="text" class="form-control" id="meetupLocation"
                                        x-ref="meetupLocationInput" wire:model.defer="meetupLocation"
                                        placeholder="Enter meetup location">
                                    @error('meetupLocation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meetupTime" class="form-label">Preferred Time</label>
                                    <input type="datetime-local" class="form-control" id="meetupTime"
                                        wire:model.defer="meetupTime">
                                    @error('meetupTime')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" wire:model.defer="message" rows="3"
                                        placeholder="Write a message to the seller"></textarea>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="bi bi-chat-text me-1"></i>
                                        Share additional details or ask questions about the item
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Send Offer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 0.5rem 1rem;
            position: absolute;
            right: 0;
            z-index: 1;
        }

        .product-image-container {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .seller-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .form-label {
            font-size: 0.9rem;
            color: #495057;
            font-weight: 500;
        }

        .form-control {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .btn-primary {
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .row {
                flex-direction: column;
            }

            .col-md-5,
            .col-md-7 {
                width: 100%;
            }

            .product-image {
                height: 120px;
            }

            .modal-body {
                padding: 0;
            }
        }
    </style>

    <script>
        function offerModalFocus() {
            return {
                setInitialFocus() {
                    // Wait for the next tick to ensure the modal is fully rendered
                    this.$nextTick(() => {
                        @if ($product->price_type == 'Fixed')
                            this.$refs.meetupLocationInput.focus();
                        @else
                            this.$refs.offerPriceInput.focus();
                        @endif
                    });
                }
            }
        }
    </script>
</div>
