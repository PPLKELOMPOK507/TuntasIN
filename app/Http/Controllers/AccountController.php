<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Show the account balance page for Penyedia Jasa
     */
    public function balance()
    {
        // Redirect non-Penyedia Jasa users
        if (Auth::user()->role !== 'Penyedia Jasa') {
            return redirect()->route('dashboard');
        }
        
        // Get the current user
        $user = Auth::user();
        
        // Get the account balance
        $balance = $user->balance ?? 142008; // Default value for testing
        
        // Get transaction history if you have it
        $transactions = []; // Replace with actual transaction data
        
        return view('account.balance', [
            'balance' => $balance,
            'transactions' => $transactions
        ]);
    }
    
    public function withdraw(Request $request)
    {
    // Validasi dasar amount dan withdraw_method
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'withdraw_method' => 'required|in:bank,ewallet',
        // Kondisional validasi sesuai metode:
        'bank_account' => 'required_if:withdraw_method,bank|string',
        'ewallet_phone' => 'required_if:withdraw_method,ewallet|string',
    ]);

    $user = Auth::user();

    if ($validated['amount'] > ($user->balance ?? 0)) {
        return back()->with('error', 'Saldo tidak cukup untuk penarikan');
    }

    if ($validated['withdraw_method'] === 'bank') {
        $account = $validated['bank_account'];
        // Proses penarikan via bank dengan nomor rekening $account
    } elseif ($validated['withdraw_method'] === 'ewallet') {
        $phone = $validated['ewallet_phone'];
        // Proses penarikan via e-wallet dengan nomor telepon $phone
    } else {
        return back()->with('error', 'Metode penarikan tidak valid');
    }

    // Contoh: buat record penarikan atau proses lain di sini

    return redirect()->route('account.balance')->with('success', 'Permintaan penarikan berhasil diajukan');
    }

}