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
        // Ganti 'status' menjadi 'review' agar sesuai dengan input form
        $request->validate([
            'review' => 'required|in:approved,rejected',
            'admin_notes' => 'required|string',
        ]);

        $refund = Refund::findOrFail($id);

        $refund->update([
            'status' => $request->review,
            'admin_notes' => $request->admin_notes,
            'admin_reviewed_at' => now()
        ]);

        // Jika refund disetujui (approved)
        if ($request->review === 'approved') {
            $pemesanan = $refund->pemesanan;

            // // Update status pemesanan jika perlu
            // $pemesanan->update(['status' => 'refunded']);

            // Kembalikan dana ke user
            $user = $refund->user;
            if (isset($user->balance) && isset($pemesanan->total_price)) {
                $user->increment('balance', $pemesanan->total_price);
            }

            // Kurangi balance penyedia jasa
            $penyediaJasa = $pemesanan->jasa->user ?? null;
            if ($penyediaJasa && isset($penyediaJasa->balance) && isset($pemesanan->total_price)) {
                $penyediaJasa->decrement('balance', $pemesanan->total_price);
            }
        }

        return redirect()
            ->route('manage')
            ->with('success', 'Review refund berhasil disimpan');
    }
}