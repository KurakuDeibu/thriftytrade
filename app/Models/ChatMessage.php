<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $appends= ['selfOwned'];

    protected $fillable = [
        'user_id',
        'receiver_id',
        'products_id',
        'messages',
    ];

    protected $dates = ['sent_at'];

    public function getSelfOwnedAttribute(): bool
    {
        return $this->user_id === auth()->user()->id;
    }
     // A chat message belongs to a sender (user)
     public function sender() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A chat message belongs to a receiver (user)
    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function offers() {
        return $this->belongsTo(Offer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
      // The recievers product
      public function products() {
        return $this->belongsTo(Products::class, 'products_id', 'id');
    }


    function receiverProfile() : BelongsTo {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}