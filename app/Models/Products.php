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
        'productimages_id',
        'prodName',
        'prodPrice',
        'prodCondition',
        'prodImage',
        'prodDescription',
        'featured',
        // 'is'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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