<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    public function buyer() {
        return $this->belongsTo(User::class);
    }

    // A transaction involves a product
    public function product() {
        return $this->belongsTo(Product::class);
    }

    // A transaction can have a finder (user)
    public function finder() {
        return $this->belongsTo(User::class);
    }
}
