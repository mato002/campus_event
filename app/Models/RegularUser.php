<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class RegularUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'regular_users'; // Define table explicitly

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'verification_code',
        'is_verified',
        'phone',
        'location',
        'bio',
        'status',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Define the many-to-many relationship with events.
     */
    public function bookedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_regular_user', 'regular_user_id', 'event_id')->withTimestamps();
    }
}
