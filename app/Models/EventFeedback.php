<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RegularUser;  // Import the RegularUser model

class EventFeedback extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's pluralization convention
    protected $table = 'event_feedback';

    // Define which columns are mass assignable
    protected $fillable = [
        'event_id',    // Foreign key to the events table
        'regular_user_id', // Foreign key to the regular_users table (not users)
        'rating',      // Rating given by the user (e.g., 1-5)
        'comment',     // Feedback comment
    ];

    // Relationships with the Event model (Each feedback belongs to an event)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relationships with the RegularUser model (Each feedback belongs to a regular user)
    public function regularUser()
    {
        return $this->belongsTo(RegularUser::class, 'regular_user_id');
    }
    // In Event.php
    public function feedback()
    {
        return $this->hasMany(EventFeedback::class, 'event_id');
    }
    

}
