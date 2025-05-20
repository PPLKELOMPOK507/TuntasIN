<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
    protected $table = 'reviewratings';
    
    protected $fillable = [
        'user_id',
        'jasa_id',
        'rating',
        'review'
    ];

    // Relasi ke user (pemberi review)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke jasa
    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}
