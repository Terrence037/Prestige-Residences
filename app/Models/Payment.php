<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id', 
        'buyer_id', 
        'amount', 
        'payment_method', 
        'receipt_image', 
        'payment_status'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}