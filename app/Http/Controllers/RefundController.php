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
            'reason' => 'required|string|max:1000',
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

    public function listRefundRequests()
    {
        $refunds = \DB::table('refunds')
            ->join('orders', 'refunds.order_id', '=', 'orders.id')
            ->where('orders.seller_id', auth()->id()) // Hanya refund untuk jasa milik penyedia
            ->select('refunds.*', 'orders.service_name', 'orders.created_at as order_date')
            ->orderBy('refunds.created_at', 'desc')
            ->get();

        return view('refund.list', compact('refunds'));
    }

    public function showRefundDetail($id)
    {
        $refund = \DB::table('refunds')
            ->join('orders', 'refunds.order_id', '=', 'orders.id')
            ->where('refunds.id', $id)
            ->where('orders.seller_id', auth()->id()) // Pastikan refund milik penyedia
            ->select('refunds.*', 'orders.service_name', 'orders.created_at as order_date', 'orders.buyer_name')
            ->first();

        if (!$refund) {
            return redirect()->route('refund.list')->with('error', 'Detail refund tidak ditemukan.');
        }

        return view('refund.detail', compact('refund'));
    }
}