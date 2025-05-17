<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'method', 'destination', // contoh field
    ];

    public function balance()
    {
        $userId = auth()->id();
        $withdrawals = Withdrawal::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        // Sesuaikan ambil saldo user juga jika ada

        return view('account.balance', compact('withdrawals'));
    }

}
