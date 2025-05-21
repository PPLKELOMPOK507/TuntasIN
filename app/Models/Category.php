<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{ 
    use HasFactory;

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function index()
    {
    $categories = Category::all(); // Ambil semua kategori
    return view('main.posts.forum', compact('categories'));
    }   

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
