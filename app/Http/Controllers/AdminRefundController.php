<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;

class AdminRefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::with(['pemesanan.jasa', 'user'])
            ->latest()
            ->get();

        return view('admin.refunds.index', compact('refunds'));
    }

    public function show($id)
    {
        $refund = Refund::with(['pemesanan.jasa', 'user'])
            ->findOrFail($id);

        return view('refunds.detailadmin', compact('refund'));
    }

    public function review(Request $request, $id)
    {
        $request->validate([
            'review' => 'required|in:approved,rejected',
            'admin_notes' => 'required|string|min:10',
        ]);

        $refund = Refund::findOrFail($id);
        
        // Jika provider reject dan admin approved = Override penolakan provider
        // Jika provider reject dan admin rejected = Setuju dengan penolakan provider
        $refund->update([
            'status' => $request->review,
            'admin_notes' => $request->admin_notes,
            'admin_reviewed_at' => now()
        ]);

        if ($request->review === 'approved') {
            // Proses refund dana ke user
            $pemesanan = $refund->pemesanan;
            $user = $refund->user;
            
            if ($user && $pemesanan) {
                $user->increment('balance', $pemesanan->harga);
                
                // Kurangi balance penyedia jasa
                $penyediaJasa = $pemesanan->jasa->user;
                if ($penyediaJasa) {
                    $penyediaJasa->decrement('balance', $pemesanan->harga);
                }
                $pemesanan->update(['status' => 'refunded']);
            }
        }

        $message = $request->review === 'approved' ? 
            ($refund->provider_response === 'rejected' ? 
                'Admin override: Refund disetujui meskipun ditolak penyedia' : 
                'Refund disetujui oleh admin') :
            ($refund->provider_response === 'rejected' ? 
                'Admin setuju dengan penolakan penyedia' : 
                'Refund ditolak oleh admin');

        return redirect()->route('manage')
            ->with('success', $message);
    }
}