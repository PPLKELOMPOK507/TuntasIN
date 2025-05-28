<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function history()
    {
        if (Auth::user()->role !== 'Pengguna Jasa') {
            return redirect()->route('dashboard')
                ->with('error', 'Unauthorized access');
        }

        // Get user's purchase history
        $purchases = Pemesanan::where('user_id', Auth::id())
            ->with(['jasa', 'jasa.user', 'payment']) // Include service, provider, and payment details
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchases.history', compact('purchases'));
    }
}