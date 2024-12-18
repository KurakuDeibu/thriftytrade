<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'user_id',
        'category_id',
        'location',
        'prodName',
        'prodPrice',
        'prodQuantity',
        'prodCondition',
        'prodImage',
        'prodDescription',
        'featured',
        'status', // added status, deleted status database instead
        'price_type' // added price type ,- fixed, negotiable
    ];

    const STATUS_AVAILABLE = 'Available';
    const STATUS_PENDING = 'Pending';
    const STATUS_SOLD = 'Sold';

    const PRICE_TYPE_FIXED = 'Fixed';
    const PRICE_TYPE_NEGOTIABLE = 'Negotiable';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'products_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'products_id');
    }

    public function scopeFeatured($query)
    {
        //SHOW FEATURE PRODUCT
        $query->where('featured', true);
    }

    public function getProductImage()
    {
        $isURL = str_contains($this->prodImage, 'http');

        return ($isURL) ? $this->prodImage : Storage::url($this->prodImage);
    }

}