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
            // Buat payment reference
            $paymentReference = 'PAY-' . uniqid();

            // Buat record pembayaran dengan status awaiting_verification
            Payment::create([
                'pemesanan_id' => $pemesanan->id,
                'user_id' => auth()->id(),
                'amount' => $pemesanan->harga,
                'payment_method' => $request->payment_method,
                'status' => 'awaiting_verification',
                'payment_reference' => $paymentReference
            ]);

            // Update status pemesanan 
            $pemesanan->update(['status' => 'awaiting_verification']);

            return redirect()->route('purchases.history')
                ->with('success', 'Pembayaran sedang diverifikasi admin');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memproses pembayaran');
        }
    }
}