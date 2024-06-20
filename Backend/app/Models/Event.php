<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'title', 'description', 'location', 'start_datetime', 'end_datetime', 'image_link', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
