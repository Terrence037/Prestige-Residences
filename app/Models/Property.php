<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'agent_id', 'title', 'description', 'property_type', 'price', 
        'bedrooms', 'bathrooms', 'floor_area', 'lot_area', 
        'address', 'city', 'status', 'featured_image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'float',
        'floor_area' => 'integer',
        'lot_area' => 'integer',
        'created_at' => 'datetime',
    ];

    // THIS IS THE MISSING PART:
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}