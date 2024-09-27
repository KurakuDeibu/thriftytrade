<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodName',
        'prodPrice',
        'prodCondition',
        'prodImage',
        'prodDescription',
        'prodCommissionFee',
        // 'is'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }

    public function scopeRecommended($query)
    {
        return $query->inRandomOrder()->paginate(4);
    }
}
