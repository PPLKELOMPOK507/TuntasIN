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
        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet,qris',
            'phone' => 'required|regex:/^[0-9]{10,13}$/',
        ]);

        // Generate unique payment reference
        $paymentReference = 'PAY-' . uniqid();

        // Create payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'amount' => $pemesanan->harga,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_reference' => $paymentReference
        ]);

        // Update pemesanan status if needed
        $pemesanan->update(['status' => 'awaiting_payment']);

        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran sedang diproses. Reference: ' . $paymentReference);
    }
}