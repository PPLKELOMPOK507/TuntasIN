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
    
    /**
     * Process a withdrawal request
     */
    public function withdraw(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_account' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Check if user has sufficient balance
        if ($validated['amount'] > ($user->balance ?? 0)) {
            return back()->with('error', 'Insufficient balance for withdrawal');
        }
        
        
        return redirect()->route('account.balance')->with('success', 'Withdrawal request submitted successfully');
    }
}