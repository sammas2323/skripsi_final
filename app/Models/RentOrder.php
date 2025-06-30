<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_id',
        'user_id',
        'name',
        'email',
        'phone',
        'tanggal_mulai_sewa',
        'jumlah_bulan',
        'total_harga',
        'status',
        'status_payment',
        'midtrans_order_id',
    ];

    protected $casts = [
        'tanggal_mulai_sewa' => 'date',
    ];

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
