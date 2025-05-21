<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class WithdrawalsController extends Controller
{
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'withdraw_method' => 'required|in:bank,ewallet',
            'bank_account' => 'required_if:withdraw_method,bank',
            'ewallet_phone' => 'required_if:withdraw_method,ewallet',
        ]);

        $user = auth()->user();

        // Cek apakah saldo cukup
        if ($request->amount > $user->balance) {
            return back()->withErrors(['amount' => 'Saldo tidak cukup untuk melakukan penarikan.']);
        }

        $destination = $request->withdraw_method === 'bank'
            ? $request->bank_account
            : $request->ewallet_phone;

        // Buat withdrawal record
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => $request->withdraw_method,
            'destination' => $destination,
        ]);

        // Kurangi saldo user
        $user->balance -= $request->amount;
        $user->save();

        return redirect()->route('account.balance')->with('success', 'Withdrawal request submitted.');
    }
}
