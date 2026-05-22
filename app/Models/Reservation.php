<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'property_id', 
        'buyer_id', 
        'reservation_fee', 
        'reservation_status', 
        'payment_status'
    ];

    protected $casts = [
        'reservation_fee' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // MISSING RELATIONSHIP TO ADD:
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}