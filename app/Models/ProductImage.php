<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = "productimages";

    protected $fillable = [
        'products_id',
        'imageURL',
    ];

    // A product image belongs to a product
    public function product() {
        return $this->belongsTo(Products::class);
    }
}