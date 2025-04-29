<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jasa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class JasaController extends Controller
{
    public function Service()
    {
        $jasa = Jasa::where('user_id', auth()->id())->get();
        return view('services', compact('jasa'));
    }

    public function create()
    {
        return view('addServices');
    }

    public function store(Request $request)
    {
        // Validasi input termasuk gambar
        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'minimal_harga' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Simpan gambar ke folder public/storage/jasa
        $gambarPath = $request->file('gambar')->store('jasa', 'public');
    
        // Simpan ke database dengan menambahkan user_id
        Jasa::create([
            'user_id' => Auth::id(),
            'nama_jasa' => $validated['nama_jasa'],
            'deskripsi' => $validated['deskripsi'],
            'minimal_harga' => $validated['minimal_harga'],
            'gambar' => $gambarPath,
        ]);
    
        return redirect()->route('services')->with('success', 'Jasa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jasa = Jasa::findOrFail($id);
        return view('serviceUpdate', compact('jasa'));
    }

    public function update(Request $request, $id)
    {
        $jasa = Jasa::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'minimal_harga' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($jasa->gambar);

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('jasa', 'public');
            $jasa->gambar = $gambarPath;
        }

        // Update data jasa
        $jasa->update([
            'nama_jasa' => $validated['nama_jasa'],
            'deskripsi' => $validated['deskripsi'],
            'minimal_harga' => $validated['minimal_harga'],
        ]);

        return redirect()->route('services')->with('success', 'Jasa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Ambil data jasa berdasarkan ID
        $jasa = Jasa::findOrFail($id);

        // Hapus gambar dari storage
        Storage::disk('public')->delete($jasa->gambar);

        // Hapus data jasa dari database
        $jasa->delete();

        return redirect()->route('services')->with('success', 'Jasa berhasil dihapus!');
    }
}
