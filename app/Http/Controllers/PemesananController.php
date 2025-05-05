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
        'catatan' => 'nullable|string',
        'tanggal_mulai' => 'required|date|after_or_equal:today',
    ]);

    Pemesanan::create([
        'user_id' => auth()->id(),
        'jasa_id' => $jasaId,
        'catatan' => $request->catatan,
        'tanggal_mulai' => $request->tanggal_mulai,
        'status' => 'Menunggu Konfirmasi',
    ]);

    return redirect()->route('dashboard')->with('success', 'Pemesanan berhasil dibuat!');
    }   
}
