<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = "productimages";

    // A product image belongs to a product
    public function product() {
        return $this->belongsTo(Product::class, 'productID');
    }
}