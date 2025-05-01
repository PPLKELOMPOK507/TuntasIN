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
}
