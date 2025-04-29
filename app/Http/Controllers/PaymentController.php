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
            'user_x id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        // Simulasi status payment: sukses atau gagal (dummy)
        $paymentSuccess = true; // ubah ke false untuk test gagal

        if ($paymentSuccess) {
            $paymentReference = uniqid('pay_');

            $payment = new Payment([
                'user_id' => $validated['user_id'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'status' => 'paid',
                'payment_reference' => $paymentReference
            ]);

            // Kirim notifikasi sukses (via response JSON)
            return response()->json([
                'message' => 'Pembayaran berhasil diproses.',
                'notification' => 'Terima kasih, pembayaran Anda berhasil.',
                'payment' => $payment
            ], 200);
        } else {
            // Kirim notifikasi gagal (via response JSON)
            return response()->json([
                'message' => 'Pembayaran gagal diproses.',
                'notification' => 'Maaf, pembayaran Anda gagal. Silakan coba lagi.',
            ], 400);
        }
    }

    public function submitPayment(Request $request)
    {
        // Simulasi status pembayaran (berhasil/gagal)
        $paymentSuccess = rand(0, 1) === 1; // Random untuk simulasi

        if ($paymentSuccess) {
            return redirect()->route('dashboard')->with('status', 'success')->with('message', 'Pembayaran berhasil diproses.');
        } else {
            return redirect()->route('dashboard')->with('status', 'error')->with('message', 'Pembayaran gagal. Silakan coba lagi.');
        }
    }
}