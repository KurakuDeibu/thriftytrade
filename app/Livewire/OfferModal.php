<?php

namespace App\Livewire;

use App\Models\Offer;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OfferModal extends Component
{
    public $product;
    public $offerPrice;
    public $meetupLocation;
    public $meetupTime;
    public $message;

    protected $rules = [
        'offerPrice' => 'required|numeric|min:1',
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

          // If it's a fixed-price item, set the offer price to the product price
          if ($this->product->price_type == 'Fixed') {
            $this->offerPrice = $this->product->prodPrice;
        }

        $this->validate([
            'meetupLocation' => 'required|string',
            'meetupTime' => 'required|date',
            'message' => 'nullable|string',
            'offerPrice' => $this->product->price_type == 'Fixed'
                ? 'in:' . $this->product->prodPrice
                : 'required|numeric|min:1'
            ], [
                'offerPrice.in' => 'For fixed-price items, the offer price must match the product price.',
                'offerPrice.required' => 'Please enter an offer price.',
                'offerPrice.numeric' => 'The offer price must be a number.',
                'offerPrice.min' => 'The offer price must be at least 1.'
            ]);



            // Rest of the offer submission logic
            Offer::create([
                'products_id' => $this->product->id,
                'user_id' => auth()->id(),
                'offer_price' => $this->offerPrice,
                'meetup_location' => $this->meetupLocation,
                'meetup_time' => $this->meetupTime,
                'message' => $this->message,
                'status' => 'pending'
            ]);

        session()->flash('success', 'Your offer has been submitted successfully!');

        $this->reset(['offerPrice', 'meetupLocation', 'meetupTime', 'message']);
        $this->dispatch('offerSubmitted');

    }

    public function render()
    {
        return view('livewire.offer-modal');
    }
}