<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['name'];

    public function jasa()
    {
        return $this->hasMany(Jasa::class, 'category_id');
    }
}
