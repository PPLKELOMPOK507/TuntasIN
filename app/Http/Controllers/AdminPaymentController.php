<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AdminPaymentController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index()
    {
        $payments = Payment::with(['user', 'pemesanan.jasa'])
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('admin', compact('payments'));
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
    public function update(Request $request, Payment $payment)
    {
        $payment->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui');
    }
}