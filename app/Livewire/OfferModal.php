<?php

namespace App\Livewire;

use App\Models\Offer;
use App\Models\Products;
use App\Notifications\ReceivedOfferNotification;
use Filament\Livewire\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class OfferModal extends Component
{
    public $product;
    public $offerPrice;
    public $offeredFindersFee;
    public $meetupLocation;
    public $meetupTime;
    public $message;

    public $successMessage = '';

    protected $listeners = [
        'offer-submitted' => 'refreshPage'
    ];

    protected $rules = [
        'meetupLocation' => 'required|string',
        'meetupTime' => 'required|date',
        'message' => 'nullable|string',
    ];

    public function mount(Products $product)
    {
        $this->product = $product;
    }

    public function submitOffer()
    {

        // Ensure product exists before proceeding
        if (!$this->product) {
            $this->addError('product', 'Product not found');
            return;
        }
        // Check the number of existing offers for this product by the current user
        $existingOffers = Offer::where('products_id', $this->product?->id)
        ->where('user_id', auth()->id())
        ->count();

        // Check if user has already reached the maximum number of offers
        if ($existingOffers >= 5) {
            $this->addError('offer_limit', 'You have reached the maximum limit of 5 offers for this product.');
            return;
        }

          // If price type is fixed-price , set the offer price to the product price
          if ($this->product?->price_type == 'Fixed') {
            $this->offerPrice = $this->product?->prodPrice;
        }

            $rules = [
                'meetupLocation' => 'required|string',
                'meetupTime' => 'required|date',
                'message' => 'nullable|string',
            ];

            // Add dynamic validation based on product type
            if ($this->product->is_looking_for && auth()->user()->isFinder) {
                $rules['offeredFindersFee'] = 'required|numeric|min:0|max:' . $this->product->finders_fee;
                $rules['offerPrice'] = 'required|numeric|min:1';
            } else {
                $rules['offerPrice'] = $this->product->price_type == 'Fixed'
                    ? 'in:' . $this->product->prodPrice
                    : 'required|numeric|min:1';
            }

            $this->validate($rules, [
                'offeredFindersFee.required' => 'Please specify the finders fee you are offering.',
                'offeredFindersFee.max' => 'Your offered finders fee cannot exceed the maximum set.',
                'offerPrice.required' => 'Please enter an offer price.',
                'offerPrice.numeric' => 'The offer price must be a number.',
                'offerPrice.min' => 'The offer price must be at least 1.',
            ]);

            // Create offer with additional finder details if applicable
            $offerData = [
                'products_id' => $this->product->id,
                'user_id' => auth()->id(),
                'offer_price' => $this->offerPrice,
                'meetup_location' => $this->meetupLocation,
                'meetup_time' => $this->meetupTime,
                'message' => $this->message,
                'status' => 'pending'
            ];

            // Add finder-specific fields if applicable
            if ($this->product->is_looking_for && auth()->user()->isFinder) {
                $offerData['offered_finders_fee'] = $this->offeredFindersFee;
            }

            $offer = Offer::create($offerData);


                if ($offer) {
                    // notify the recipient of the offer
                    Notification::send($offer->product->author, new ReceivedOfferNotification($offer));

                    $this->successMessage = 'Your offer has been successfully sent!';
                    // Browser event to trigger page reload
                    $this->dispatch('offer-submitted');
                    $this->reset(['offerPrice', 'offeredFindersFee', 'meetupLocation', 'meetupTime', 'message']);
            }
        }

    public function clearMessages()
    {
        $this->successMessage = '';
    }

    public function refreshPage()
    {
        $this->reset();
    }

        public function getRemainingOfferSlotsProperty()
    {
        $existingOffers = Offer::where('products_id', $this->product?->id)
            ->where('user_id', auth()->id())
            ->count();

        return 5 - $existingOffers;
    }


    public function render()
    {
        return view('livewire.offer-modal');
    }
}
