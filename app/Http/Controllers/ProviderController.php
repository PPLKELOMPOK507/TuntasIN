<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller 
{
    public function __construct() 
    {
        // Hapus middleware di sini karena sudah diterapkan di route group
        // $this->middleware('auth');
        // $this->middleware('provider');
    }

    // Show provider profile
    public function show($id)
    {
        $provider = User::findOrFail($id);
        return view('provider.profile', compact('provider'));
    }

    // Show provider's refund detail
    public function showRefund($id) 
    {
        $refund = Refund::findOrFail($id);
        
        // Verify provider owns this refund
        if($refund->pemesanan->jasa->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('refunds.detail', compact('refund'));
    }

    // Handle provider's refund response
    public function respondToRefund(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);
        
        // Verify provider owns this refund
        if($refund->pemesanan->jasa->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // Validate request
        $request->validate([
            'response' => 'required|in:accepted,rejected'
        ]);

        // Update provider response
        $refund->update([
            'provider_response' => $request->response,
            'provider_responded_at' => now()
        ]);

        $message = $request->response === 'accepted' ? 
            'Refund telah disetujui dan menunggu verifikasi admin' : 
            'Refund telah ditolak';

        // Redirect ke riwayat penjualan dengan pesan
        return redirect()->route('sales.history')
            ->with('success', $message);
    }
}