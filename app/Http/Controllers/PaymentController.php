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
        // Validasi input
        $validated = $request->validate([
            'full_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255', // Hanya huruf dan spasi
            'phone' => 'required|regex:/^[0-9]+$/|min:10|max:13', // Hanya angka, 10-13 digit
            'address' => 'required|string',
            'seller_name' => 'required|regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            'service_description' => 'required|string',
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet,qris'
        ], [
            'full_name.regex' => 'Nama lengkap hanya boleh berisi huruf',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka',
            'phone.min' => 'Nomor telepon minimal 10 digit',
            'phone.max' => 'Nomor telepon maksimal 13 digit',
            'seller_name.regex' => 'Nama penjual hanya boleh berisi huruf'
        ]);

        try {
            // Generate payment reference
            $paymentReference = 'PAY-' . uniqid();

            // Simulasi pembayaran (70% berhasil, 30% gagal)
            $isSuccessful = (rand(1, 100) <= 70);

            if ($isSuccessful) {
                return redirect()
                    ->route('dashboard')
                    ->with('status', 'success')
                    ->with('message', "Pembayaran berhasil! Reference: {$paymentReference}");
            } else {
                return redirect()
                    ->route('dashboard')
                    ->with('status', 'error')
                    ->with('message', 'Pembayaran gagal. Silakan coba lagi.');
            }

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('status', 'error')
                ->with('message', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }
}