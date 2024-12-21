<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewer_id',
        'reviewee_id',
        'offer_id',
        'products_id',
        'rating',
        'content'
    ];

    public function offer()
{
    return $this->belongsTo(Offer::class, 'offer_id');
}

public function reviewer()
{
    return $this->belongsTo(User::class, 'reviewer_id');
}

public function reviewee()
{
    return $this->belongsTo(User::class, 'reviewee_id');
}

public function product()
{
    return $this->belongsTo(Products::class, 'products_id');
}

// Check if review exists for an offer
public static function checkReviewExists($offerId, $reviewerId)
{
    return self::where('offer_id', $offerId)
               ->where('reviewer_id', $reviewerId)
               ->exists();
}
public function getRoleAttribute()
    {
        // Check if this is a Looking For product
        $product = Products::find($this->products_id);

        // If it's a Looking For product, set role as Finder
        if ($product && $product->is_looking_for) {
            return 'Finder Transaction';
        }

        // Existing logic for non-looking for products
        $offer = Offer::where('products_id', $this->products_id)
            ->where('user_id', $this->reviewee_id)
            ->first();

        return $offer ? 'Seller' : 'Buyer';
    }
}