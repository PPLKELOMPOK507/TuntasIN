<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    // Menampilkan form pembayaran (nanti bisa dihubungkan dengan view)
    public function showPaymentForm()
    {
        return view('payment.form'); // Buat file blade jika perlu
    }

    // Memproses pembayaran
    public function processPayment(Request $request)
    {
        // Validasi input dari form atau frontend
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        // Simulasi respons sukses dari payment gateway
        $paymentReference = uniqid('pay_');

        $payment = new Payment([
            'user_id' => $validated['user_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'paid', // asumsi langsung sukses
            'payment_reference' => $paymentReference
        ]);

        // Tidak disimpan ke database karena belum ada migration

        return response()->json([
            'message' => 'Pembayaran berhasil diproses.',
            'payment' => $payment
        ]);
    }
}
