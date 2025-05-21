<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Jasa extends Model
{
    protected $table = 'jasas';

    protected $fillable = [
        'user_id',
        'category_id',
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
}
