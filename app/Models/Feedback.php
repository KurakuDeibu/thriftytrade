<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = "feedbacks";

    // Feedback belongs to a product
    public function product() {
        return $this->belongsTo(Product::class);
    }

    // Feedback belongs to a user
    public function user() {
        return $this->belongsTo(User::class);
    }

}