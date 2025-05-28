<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm(Pemesanan $pemesanan)
    {
        // Verify if the user owns this pemesanan
        if ($pemesanan->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        return view('payment.form', compact('pemesanan'));
    }

    public function processPayment(Request $request, Pemesanan $pemesanan)
    {
        try {
            $request->validate([
                'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet,qris'
            ]);

            // Generate unique payment reference
            $paymentReference = 'PAY-' . uniqid();

            // Create payment record
            Payment::create([
                'pemesanan_id' => $pemesanan->id,
                'user_id' => auth()->id(),
                'amount' => $pemesanan->harga,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'payment_reference' => $paymentReference
            ]);

            // Update order status
            $pemesanan->update(['status' => 'awaiting_verification']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil! Akan diverifikasi oleh Admin',
                'redirect' => route('riwayat-pembelian')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran'
            ], 500);
        }
    }
}