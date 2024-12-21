<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'seller_id',
        'products_id',
        'offer_price',
        'offered_finders_fee',
        'meetup_location',
        'meetup_time',
        'message',
        'status',
    ];

    protected $dates = ['meetup_time'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'offer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hasBeenReviewedByUser($userId)
    {
        return $this->reviews()->where('reviewer_id', $userId)->exists();
    }

     // Scope to get offers for a specific product and user
     public function scopeForProductAndUser($query, $productId, $userId)
     {
         return $query->where('products_id', $productId)
                      ->where('user_id', $userId);
     }
}