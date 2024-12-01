<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $table = "reports";

    protected $fillable = [
        'user_id',
        'products_id',
        'reported_user_id',
        'report_type',
        'reason',
        'details',
        'status'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Mutators and Accessors
    public function getFormattedReasonAttribute()
    {
        $reasons = [
            'inappropriate' => 'Inappropriate Content',
            'fraud' => 'Fraudulent Listing',
            'spam' => 'Spam or Scam',
            'misleading' => 'Misleading Information',
            'duplicate' => 'Duplicate Listing',
            'other' => 'Other'
        ];

        return $reasons[$this->reason] ?? 'Unknown';
    }
}