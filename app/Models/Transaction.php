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
        'tranDate',
        'quantity',
        'totalPrice',
        'tranStatus',
        'systemCommission',
        'finderCommission',

    ];
    public function buyer() {
        return $this->belongsTo(User::class);
    }

    // A transaction involves a product
    public function product() {
        return $this->belongsTo(Products::class);
    }

    // A transaction can have a finder (user)
    public function finder() {
        return $this->belongsTo(User::class);
    }
}