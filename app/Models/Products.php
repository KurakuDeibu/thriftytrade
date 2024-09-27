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

    protected $fillable = [
        'user_id',
        'prodName',
        'prodPrice',
        'prodCondition',
        'prodImage',
        'prodDescription',
        'prodCommissionFee',
        'featured',
        // 'is'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getProductImage()
    {
        $isURL = str_contains($this->prodImage, 'http');

        return ($isURL) ? $this->prodImage : Storage::url($this->prodImage);
    }
}
