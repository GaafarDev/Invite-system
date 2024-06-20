<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'fullname', 'email', 'phone', 'gender', 'password', 'website', 'company', 'address', 'city', 'country', 'postcode', 'pic_url'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function ticketSales()
    {
        return $this->hasMany(TicketSale::class);
    }
}
