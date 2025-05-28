<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans'; // pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'jasa_id',
        'catatan',
        'tanggal_mulai',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Jasa
    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    // Memeriksa apakah pemesanan memiliki ulasan
    public function hasReview()
    {
        return $this->hasOne(ReviewRating::class)->exists();
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
