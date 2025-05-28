<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pemesanan;
use App\Models\Refund;

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

        return redirect()->route('dashboard')
            ->with('success', 'Permohonan refund berhasil diajukan.');
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

    public function create($pemesanan_id)
    {
        $pemesanan = Pemesanan::findOrFail($pemesanan_id);
        
        // Cek apakah pesanan milik user yang login
        if ($pemesanan->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('refunds.create', compact('pemesanan'));
    }

    public function store(Request $request, $pemesanan_id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
            'bukti_refund' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pemesanan = Pemesanan::findOrFail($pemesanan_id);

        // Cek apakah pesanan milik user yang login
        if ($pemesanan->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        // Upload bukti refund
        $buktiPath = $request->file('bukti_refund')->store('refund-bukti', 'public');

        // Buat refund request
        Refund::create([
            'pemesanan_id' => $pemesanan_id,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'bukti_refund' => $buktiPath,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Permintaan refund berhasil diajukan');
    }

    public function index()
    {
        $refunds = Refund::where('user_id', auth()->id())
            ->with('pemesanan.jasa')
            ->latest()
            ->get();

        return view('refunds.index', compact('refunds'));
    }
}