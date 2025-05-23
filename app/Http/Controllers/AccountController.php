<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class AccountController extends Controller
{

    public function balance()
    {
        $user = auth()->user();

        $withdrawals = Withdrawal::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('account.balance', compact('withdrawals'));
    }


    public function withdrawals()
    {
        $withdrawals = Withdrawal::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('account.withdrawals', compact('withdrawals'));
        
    }

    
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = auth()->user();
        $user->balance += $request->amount;
        $user->save();

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }


}