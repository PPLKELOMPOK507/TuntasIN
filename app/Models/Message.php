<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'jasa_id',
        'message',
        'price_offer'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}