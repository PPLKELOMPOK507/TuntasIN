<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'pemesanan_id',
        'user_id',
        'reason',
        'bukti_refund',
        'status',
        'provider_response',      
        'provider_responded_at',  
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}