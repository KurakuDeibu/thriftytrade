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
        $this->validate();

        $offer = Offer::create([
            'user_id' => Auth::id(),
            'products_id' => $this->product->id,
            'offer_price' => $this->offerPrice,
            'meetup_location' => $this->meetupLocation,
            'meetup_time' => $this->meetupTime,
            'message' => $this->message,
        ]);

        $this->product->status = 'Pending';
        $this->product->save();


        $this->reset(['offerPrice', 'meetupLocation', 'meetupTime', 'message']);
        $this->dispatch('offerSubmitted');
        session()->flash('success', 'Your offer has been submitted successfully!');

    }

    public function render()
    {
        return view('livewire.offer-modal');
    }
}