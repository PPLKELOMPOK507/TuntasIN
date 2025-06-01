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

        return view('admin.refunds.show', compact('refund'));
    }

    public function review(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'required|string|min:10',
        ]);

        $refund = Refund::findOrFail($id);
        
        $refund->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'admin_reviewed_at' => now()
        ]);

        // Jika refund disetujui
        if ($request->status === 'approved') {
            $pemesanan = $refund->pemesanan;
            
            // Update status pemesanan
            $pemesanan->update(['status' => 'refunded']);
            
            // Kembalikan dana ke user
            $user = $refund->user;
            $user->increment('balance', $pemesanan->total_price);
            
            // Kurangi balance penyedia jasa
            $penyediaJasa = $pemesanan->jasa->user;
            $penyediaJasa->decrement('balance', $pemesanan->total_price);
        }

        return redirect()
            ->route('admin.refunds.index')
            ->with('success', 'Review refund berhasil disimpan');
    }
}