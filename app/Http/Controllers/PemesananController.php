<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jasa;
use App\Models\Pemesanan;

class PemesananController extends Controller
{
    public function create($jasaId)
    {
        $jasa = Jasa::findOrFail($jasaId);
        return view('pesanan.create', compact('jasa'));
    }

    public function store(Request $request, $jasaId)
    {
        $request->validate([
            'custom_price' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
        ]);

        // Create and save the order, storing the returned model
        $pemesanan = Pemesanan::create([
            'user_id' => auth()->id(),
            'jasa_id' => $jasaId,
            'harga' => $request->custom_price,
            'catatan' => $request->catatan,
            'tanggal_mulai' => $request->tanggal_mulai,
        ]);

        // Redirect to payment form with the pemesanan ID
        return redirect()->route('payment.form', ['pemesanan' => $pemesanan->id])
            ->with('success', 'Pemesanan berhasil dibuat!');
    }
}