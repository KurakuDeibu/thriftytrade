<?php

namespace App\Livewire;

use App\Models\Offer;
use Livewire\Component;
use Livewire\WithPagination;

class ProductOffers extends Component
{
    use WithPagination;

    public $product;
    public $selectedOffer = null;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function viewOfferDetails($offerId)
    {
        $this->selectedOffer = Offer::findOrFail($offerId);
    }

    public function cancelOffer($offerId)
    {
        $offer = Offer::findOrFail($offerId);

        // Ensure only the offer creator can cancel
        if ($offer->user_id === auth()->id()) {
            $offer->delete();
            session()->flash('message', 'Offer successfully cancelled.');
        }
    }

    public function render()
    {
        $offers = Offer::where('products_id', $this->product->id)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.product-offers', [
            'offers' => $offers,
        ]);
    }
}
