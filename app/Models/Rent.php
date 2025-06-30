<?php
    
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Rent extends Model
{
   protected $fillable = [
      'title', 
      'address', 
      'price',  
      'slug', 
      'image'
   ];

   public function detail()
   {
    return $this->hasOne(RentDetail::class);
   }

   public function images()
   {
    return $this->hasMany(RentImage::class);
   }

   public function orders()
   {
    return $this->hasMany(RentOrder::class);
   }


}