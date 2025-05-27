<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jasa;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JasaController extends Controller
{
    // Menampilkan Dashboard berdasarkan role pengguna
    public function dashboard()
    {
        // Ambil kategori terlebih dahulu
        $categories = Category::all();
        
        if (auth()->user()->role === 'Pengguna Jasa') {
            // Ambil semua jasa dengan data penyedia jasanya dan kategori
            $jasa = Jasa::with(['user', 'category'])->get();
            return view('dashboard', compact('jasa', 'categories'));
        } else {
            // Untuk penyedia jasa, tampilkan hanya jasanya sendiri dengan kategori
            $jasa = Jasa::where('user_id', auth()->id())
                        ->with('category')
                        ->get();
            return view('dashboard', compact('jasa', 'categories'));
        }
    }

    // Halaman tambah jasa
    public function create()
    {
        // Mengambil semua kategori dari database
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
        $categories = Category::all(); // Tambahkan ini
        return view('serviceUpdate', compact('jasa', 'categories'));
    }

    // Update jasa
    public function update(Request $request, $id)
    {
        $jasa = Jasa::findOrFail($id);

        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|exists:categories,id', // Tambahkan validasi kategori
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
            'category_id' => $validated['kategori'], // Update kategori
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
