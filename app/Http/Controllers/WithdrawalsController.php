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
            // Validasi bank_account: harus ada jika withdraw_method=bank, panjang tepat 16 digit, hanya angka
            'bank_account' => 'required_if:withdraw_method,bank|digits:16',
            // Validasi ewallet_phone: harus ada jika withdraw_method=ewallet, panjang tepat 13 digit, hanya angka
            'ewallet_phone' => 'required_if:withdraw_method,ewallet|digits:13',
        ]);

        $user = auth()->user();

        if ($request->amount > $user->balance) {
            return back()->withErrors(['amount' => 'Saldo tidak cukup untuk melakukan penarikan.']);
        }


        
        $destination = $request->withdraw_method === 'bank'
            ? $request->bank_account
            : $request->ewallet_phone;

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => $request->withdraw_method,
            'destination' => $destination,
        ]);

        $user->balance -= $request->amount;
        $user->save();

        return redirect()->route('account.balance')->with('success', 'Withdrawal request submitted.');
    }

    public function store(Request $request)
    {
        // Validasi input (tambahkan aturan validasi sesuai kebutuhan)
        $request->validate([
            'withdraw_method' => 'required|in:bank,ewallet',
            'bank_account' => 'required_if:withdraw_method,bank',
            'ewallet_phone' => 'required_if:withdraw_method,ewallet',
        ]);

        // Ambil nilai metode withdraw
        $method = $request->input('withdraw_method'); // 'bank' atau 'ewallet'

        if ($method == 'bank') {
            $rekening = $request->input('bank_account');
            // Proses rekening bank sesuai logika aplikasi
        } else if ($method == 'ewallet') {
            $phone = $request->input('ewallet_phone');
            // Proses nomor telepon ewallet sesuai logika aplikasi
        }

        return redirect()->back()->with('success', 'Withdrawal request submitted!');
    }

}
