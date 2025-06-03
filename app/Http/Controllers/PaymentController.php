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
            // Validate request
            $request->validate([
                'payment_method' => 'required',
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Upload bukti pembayaran
            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            // Buat payment reference
            $paymentReference = 'PAY-' . uniqid();

            // Buat record pembayaran
            Payment::create([
                'pemesanan_id' => $pemesanan->id,
                'user_id' => auth()->id(),
                'amount' => $pemesanan->harga,
                'payment_method' => $request->payment_method,
                'status' => 'awaiting_verification',
                'payment_reference' => $paymentReference,
                'bukti_pembayaran' => $buktiPath
            ]);

            // Update status pemesanan 
            $pemesanan->update(['status' => 'awaiting_verification']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran sedang diverifikasi admin',
                'redirect' => route('purchases.history')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyPayment(Payment $payment)
    {
        \DB::beginTransaction();
        try {
            // Update status pembayaran
            $payment->update(['status' => 'completed']);
            
            // Tambah saldo penyedia jasa
            $provider = $payment->pemesanan->jasa->user;
            if ($provider->role === 'Penyedia Jasa') {
                $provider->increment('balance', $payment->amount);
            }

            \DB::commit();
            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran');
        }
    }
}