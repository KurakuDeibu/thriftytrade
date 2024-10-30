<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = "chatmessages";

     // A chat message belongs to a sender (user)
     public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // A chat message belongs to a receiver (user)
    public function receiver() {
        return $this->belongsTo(User::class, 'reciever_id');
    }

      // The recievers product
      public function recieverProductProfile() {
        return $this->belongsTo(User::class, 'reciever_id', 'id');
    }

     // A chat message belongs to a receiver (user)
     public function senderProductProfile() {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}