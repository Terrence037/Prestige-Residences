<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'profile_image',
    ];

    protected $hidden = ['password', 'remember_token'];

    // Role Helpers
    public function isAdmin() { return $this->role === 'admin'; }
    public function isAgent() { return $this->role === 'agent'; }
    public function isBuyer() { return $this->role === 'buyer'; }

    // Relationships
    public function properties() { // For Agents
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function inquiries() {
        return $this->hasMany(Inquiry::class);
    }

    public function appointments() { // As Buyer
        return $this->hasMany(Appointment::class, 'buyer_id');
    }

    public function reservations() { // As Buyer
        return $this->hasMany(Reservation::class, 'buyer_id');
    }
}