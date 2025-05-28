<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('dashboard');
        }

        $data = [
            'jasa' => \App\Models\Jasa::with(['user', 'category'])->get(),
            'totalUsers' => \App\Models\User::count(),
            'users' => \App\Models\User::all(),
            'categories' => \App\Models\Category::withCount('services')->get(),
            'payments' => \App\Models\Payment::with(['user', 'pemesanan.jasa'])->get()
        ];

        return view('admin', $data);
    }

    public function destroyJasa($id)
    {
        $jasa = Jasa::findOrFail($id);
        
        if ($jasa->gambar && Storage::disk('public')->exists($jasa->gambar)) {
            Storage::disk('public')->delete($jasa->gambar);
        }

        $jasa->delete();
        return back()->with('success', 'Jasa berhasil dihapus');
    }

    public function destroyUser($id) 
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting admin users
        if ($user->role === 'Admin') {
            return back()->with('error', 'Tidak dapat menghapus akun Admin');
        }

        // Delete user's photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // If user is service provider, delete their services
        if ($user->role === 'Penyedia Jasa') {
            foreach ($user->jasas as $jasa) {
                if ($jasa->gambar && Storage::disk('public')->exists($jasa->gambar)) {
                    Storage::disk('public')->delete($jasa->gambar);
                }
                $jasa->delete();
            }
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}