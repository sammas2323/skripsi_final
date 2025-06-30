<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentImage extends Model
{
    protected $fillable = ['rent_id', 'path'];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
