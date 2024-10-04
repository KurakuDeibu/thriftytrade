<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = "userroles";

    // A userRole belongs to a user
    public function user() {
        return $this->belongsTo(User::class, 'userReferenceID');
    }

    // A userRole belongs to a role
    public function role() {
        return $this->belongsTo(Role::class, 'roleID');
    }
}