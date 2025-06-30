<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentDetail extends Model
{
    protected $fillable = [
        'rent_id',
        'bedrooms',
        'bathrooms',
        'building_size',
        'electricity',
        'water',
    ];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
