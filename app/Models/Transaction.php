<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        'user_id',
        'products_id',
        'offer_id',
        'tranDate',
        'quantity',
        'totalPrice',
        'tranStatus',
        'systemCommission',
        'finderCommission',
        'meetup_location',
        'meetup_time',


    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A transaction involves a product
    public function product() {
        return $this->belongsTo(Products::class, 'products_id');
    }

    // A transaction can have a finder (user)
    public function finder() {
        return $this->belongsTo(User::class);
    }
}
