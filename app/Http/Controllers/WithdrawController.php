<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100000',
            'withdraw_method' => 'required|in:bank,ewallet',
            'bank_account' => 'required_if:withdraw_method,bank',
            'ewallet_phone' => 'required_if:withdraw_method,ewallet',
        ]);

        $destination = $request->withdraw_method === 'bank'
            ? $request->bank_account
            : $request->ewallet_phone;

        Withdrawal::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'method' => $request->withdraw_method,
            'destination' => $destination,
        ]);

        // Redirect ke halaman riwayat withdrawal
        return redirect()->route('account.withdrawals')->with('success', 'Withdrawal request submitted.');
    }

    public function showBalance()
    {
        $withdrawals = Withdrawal::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('account.balance', compact('withdrawals'));
    }

}
