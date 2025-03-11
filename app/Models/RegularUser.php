<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;




use Illuminate\Notifications\Notifiable;

class RegularUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'regular_users'; // Define table explicitly

    protected $fillable = ['name', 'email', 'password','profile_picture'];
    protected $hidden = ['password', 'remember_token'];





public function bookedEvents(): BelongsToMany
{
    return $this->belongsToMany(Event::class, 'event_regular_user', 'regular_user_id', 'event_id')->withTimestamps();
}

}

