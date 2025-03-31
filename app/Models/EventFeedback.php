<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RegularUser;
use App\Models\Event;  // Import Event model

class EventFeedback extends Model
{
    use HasFactory;

    protected $table = 'event_feedback';

    protected $fillable = [
        'event_id',
        'regular_user_id',
        'rating',
        'comment',
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
}
