<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
    protected $table = 'reviewratings';
    
    protected $fillable = [
        'user_id',
        'jasa_id',
        'pemesanan_id', 
        'rating',
        'review'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
