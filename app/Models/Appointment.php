<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['property_id', 'buyer_id', 'agent_id', 'appointment_date', 'status'];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function property() {
        return $this->belongsTo(Property::class);
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function agent() {
        return $this->belongsTo(User::class, 'agent_id');
    }
}