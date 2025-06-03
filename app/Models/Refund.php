<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'reason',
        'bukti_refund',
        'status',
        'provider_response',
        'provider_notes',
        'provider_responded_at',
        'admin_notes',
        'admin_reviewed_at'
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