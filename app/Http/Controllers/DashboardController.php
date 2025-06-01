<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Jasa::query();

        if ($request->filled('search')) {
            $query->where('nama_jasa', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if (Auth::user()->role === 'Pengguna Jasa') {
            // Untuk Pengguna Jasa, tampilkan semua jasa
            $jasa = $query->with(['user', 'category'])->get();
        } else {
            // Untuk Penyedia Jasa, tampilkan hanya jasanya sendiri
            $jasa = $query->where('user_id', Auth::id())->get();
        }

        return view('dashboard', compact('jasa', 'categories'));
    }
}
