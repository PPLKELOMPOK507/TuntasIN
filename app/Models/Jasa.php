<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Jasa extends Model
{
    protected $table = 'jasas';

    protected $fillable = [
        'user_id',          
        'nama_jasa',
        'deskripsi',
        'minimal_harga',
        'gambar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }
    public function penyedia()
    {
        return $this->belongsTo(User::class, 'penyedia_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function reviewratings()
    {
        return $this->hasMany(ReviewRating::class, 'jasa_id');
    }
    // Method untuk mendapatkan rata-rata rating
    public function getAverageRatingAttribute()
    {
        return $this->reviewratings()->avg('rating') ?? 0;
    }
    // Method untuk mendapatkan jumlah review
    public function getReviewsCountAttribute()
    {
        return $this->reviewratings()->count();
    }
}
