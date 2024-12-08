<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin === true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "users";

    protected $fillable = [
        'users_id',
        'firstName',
        'lastName',
        'middleName',
        'name',
        'email',
        'birthDay',
        'userAddress',
        'phoneNum',
        'password',
        'isAdmin',
    ];

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

        // In your User model
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'user_id')
            ->orWhere('receiver_id', $this->id)
            ->latest();
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'isAdmin' => 'boolean',
        ];

    }


}
