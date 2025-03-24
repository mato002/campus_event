<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'start_date',
        'end_date',
        'venue_id',
        'image', // Added 'image' to the fillable array
    ];

    /**
     * Define the relationship: An Event belongs to a Venue.
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function bookedUsers(): BelongsToMany
    {
        return $this->belongsToMany(RegularUser::class, 'event_regular_user', 'event_id', 'regular_user_id')->withTimestamps();
    }

    public function regularUsers()
    {
        return $this->belongsToMany(RegularUser::class, 'event_regular_user')->withTimestamps();
    }

    public function feedback()
    {
        return $this->hasMany(EventFeedback::class);
    }
}
