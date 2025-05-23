<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'body', // Gunakan 'body' jika tabel memiliki kolom 'body'
        'user_id', // Tambahkan user_id di sini
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function isLikedBy($user)
    {
        return $this->likes->contains('id', $user->id);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
