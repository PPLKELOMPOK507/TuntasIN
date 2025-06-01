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

    protected $casts = [
        'price_offer' => 'decimal:2'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() 
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}