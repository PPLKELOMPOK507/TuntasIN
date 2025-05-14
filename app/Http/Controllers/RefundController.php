<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class RefundController extends Controller
{
    // Menampilkan halaman refund
    public function showRefundForm()
    {
        $orders = Order::where('user_id', auth()->id())->get(); // Ambil pesanan pengguna
        return view('refund.form', compact('orders'));
    }

    // Memproses permohonan refund
    public function submitRefund(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'reason' => 'required|string|max:500',
        ]);

        foreach ($request->order_ids as $orderId) {
            // Simpan permohonan refund ke database
            \DB::table('refunds')->insert([
                'order_id' => $orderId,
                'user_id' => auth()->id(),
                'reason' => $request->reason,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Permohonan refund berhasil diajukan.');
    }
}