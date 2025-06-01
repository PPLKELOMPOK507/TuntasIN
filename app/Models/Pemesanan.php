<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';

    protected $fillable = [
        'user_id',
        'jasa_id',
        'catatan',
        'tanggal_mulai',
        'harga',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'pemesanan_id');
    }

    public function jasa(): BelongsTo
    {
        return $this->belongsTo(Jasa::class);
    }

    // Memeriksa apakah pemesanan memiliki ulasan
    public function hasReview(): HasOne
    {
        return $this->hasOne(ReviewRating::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(ReviewRating::class);
    }
}
