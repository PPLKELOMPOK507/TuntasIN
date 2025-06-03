<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'pemesanan_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'payment_reference',
        'bukti_pembayaran'  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public $timestamps = true;
}