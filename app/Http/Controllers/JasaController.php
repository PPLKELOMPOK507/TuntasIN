<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JasaController extends Controller
{
    // Menampilkan Dashboard berdasarkan role pengguna
    public function dashboard()
    {
        $categories = Category::all();
        
        if (auth()->user()->role === 'Pengguna Jasa') {
            // Ambil semua jasa dengan data penyedia jasanya
            $jasa = Jasa::with(['user', 'category'])->get();
        } else {
            // Untuk penyedia jasa, tampilkan hanya jasanya sendiri
            $jasa = Jasa::where('user_id', auth()->id())->get();
        }
        
        return view('dashboard', compact('jasa', 'categories'));
    }
    public function show($id)
{
    $jasa = Jasa::findOrFail($id);
    return view('jasa.show', compact('jasa'));
}

    // Halaman tambah jasa
    public function create()
    {
        $categories = Category::all();
        return view('addServices', compact('categories'));
    }

    // Menyimpan jasa baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|exists:categories,id',
            'minimal_harga' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan gambar ke folder public/storage/jasa
        $gambarPath = $request->file('gambar')->store('jasa', 'public');

        // Simpan data jasa ke database
        Jasa::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['kategori'],
            'nama_jasa' => $validated['nama_jasa'],
            'deskripsi' => $validated['deskripsi'],
            'minimal_harga' => $validated['minimal_harga'],
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Jasa berhasil ditambahkan!');
    }

    // Halaman edit jasa
    public function edit($id)
    {
        $jasa = Jasa::findOrFail($id);
        return view('serviceUpdate', compact('jasa'));
    }

    // Update jasa
    public function update(Request $request, $id)
    {
        $jasa = Jasa::findOrFail($id);

        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'minimal_harga' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($jasa->gambar);

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('jasa', 'public');
            $jasa->gambar = $gambarPath;
        }

        $jasa->update([
            'nama_jasa' => $validated['nama_jasa'],
            'deskripsi' => $validated['deskripsi'],
            'minimal_harga' => $validated['minimal_harga'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Jasa berhasil diperbarui!');
    }

    // Menghapus jasa
    public function destroy($id)
    {
        $jasa = Jasa::findOrFail($id);

        // Hapus gambar dari storage
        Storage::disk('public')->delete($jasa->gambar);

        // Hapus data jasa dari database
        $jasa->delete();

        return redirect()->route('dashboard')->with('success', 'Jasa berhasil dihapus!');
    }
}
