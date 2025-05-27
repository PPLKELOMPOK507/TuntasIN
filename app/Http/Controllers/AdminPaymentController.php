<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AdminPaymentController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get(); // Urutkan berdasarkan tanggal terbaru
        return view('admin.payments.index', compact('payments'));
    }

    // Menampilkan detail pembayaran
    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Pembayaran tidak ditemukan.');
        }

        return view('admin.payments.show', compact('payment'));
    }

    // Mengubah status pembayaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Payment::find($id);

        if (!$payment) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Pembayaran tidak ditemukan.');
        }

        $payment->status = $request->status;
        $payment->save();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}