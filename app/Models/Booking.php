<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'bookings';

    // Define the fillable properties (fields that can be mass-assigned)
    protected $fillable = [
        'user_id',
        'event_id', // or whatever other fields you have in the bookings table
        'booking_date',
    ];

    // Define any relationships, if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
