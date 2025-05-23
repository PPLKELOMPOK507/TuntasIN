<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'jasa' => Jasa::with('user')->get(),
            'categories' => Category::withCount('services')->get()
        ];

        return view('admin', $data);
    }

    public function destroyJasa($id)
    {
        $jasa = Jasa::findOrFail($id);
        
        // Delete the image from storage if it exists
        if ($jasa->gambar && Storage::disk('public')->exists($jasa->gambar)) {
            Storage::disk('public')->delete($jasa->gambar);
        }

        // Delete the service
        $jasa->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Jasa berhasil dihapus!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting admin users
        if ($user->role === 'Admin') {
            return back()->with('error', 'Admin users cannot be deleted');
        }

        // Delete user's photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }
}