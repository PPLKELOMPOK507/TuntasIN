<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AdminPaymentController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index()
    {
        $payments = Payment::all(); // Ambil semua data pembayaran
        return view('admin.payments.index', compact('payments'));
    }

    // Menampilkan detail pembayaran
    public function show($id)
    {
        $payment = Payment::findOrFail($id); // Ambil data pembayaran berdasarkan ID
        return view('admin.payments.show', compact('payment'));
    }

    // Mengubah status pembayaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}