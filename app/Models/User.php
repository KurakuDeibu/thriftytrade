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

        // ---FINDER INFOS----//
        'isFinder',
        'finder_status',
        'finder_document_path',
        'finder_verification_notes',
        'finder_verified_at'

    ];

    public function getIsFinderAttribute()
    {
        return $this->finder_status === 'approved';
    }

    // Scope to get pending finder requests
    public function scopePendingFinderRequests($query)
    {
        return $query->where('finder_status', 'pending');
    }

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

    public function conversations()
    {

        return $this->hasMany(Conversation::class,'sender_id')->orWhere('receiver_id',$this->id)->whereNotDeleted();
    }

    public function isFinder()
    {
        return $this->isFinder === true;
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function unreadMessagesCount()
    {
        return $this->messages()->whereNull('read_at')->count();
    }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.'.$this->id;
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