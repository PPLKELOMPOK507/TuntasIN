<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
