<?php
    
namespace App\Data;

use Illuminate\Support\Arr;

class Home
{
    public static function all()
    {
        return [
        [
            'id'=> 1,
            'slug' => 'kontrakan-jakarta-selatan',
            'title'=>'Kontrakan Harian Jakarta Selatan',
            'address'=>'Jl. Melati No. 12, Jakarta Selatan',
            'month-price'=>'Rp 2.000.000 / bulan',
            'type'=>'2 Kamar • 1 Kamar Mandi'
        ],
        [
            'id'=> 2,
            'slug' => 'kontrakan-surabaya',
            'title'=>'Kontrakan Nyaman Surabaya',
            'address'=>'Jl. Cemara No. 8, Surabaya',
            'month-price'=>'Rp 1.800.000 / bulan',
            'type'=>'3 Kamar • 2 Kamar Mandi'
        ],
        [
            'id'=> 3,
            'slug' => 'kontrakan-bandung',
            'title'=>'Kontrakan Nyaman Bandung',
            'address'=>'Jl. Cemara No. 9, Bandung',
            'month-price'=>'Rp 1.800.000 / bulan',
            'type'=>'2 Kamar • 1 Kamar Mandi'
        ],
        [
            'id'=> 4,
            'slug' => 'kontrakan-jakarta-barat',
            'title'=>'Kontrakan Nyaman Jakarta Barat',
            'address'=>'Jl. Cemara No. 9, Jakarta Barat',
            'month-price'=>'Rp 1.800.000 / bulan',
            'type'=>'2 Kamar • 1 Kamar Mandi'
        ],
    ];
    }

    public static function find($slug){
        $home = Arr::first(static::all(), fn ($home) => $home['slug'] == $slug);

        if(!$home) {
            abort(404);
        }

        return $home;
    }
}