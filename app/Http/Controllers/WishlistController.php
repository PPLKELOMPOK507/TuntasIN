<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman wishlist
     */
    public function index()
    {
        // Cek role pengguna
        if (Auth::user()->role !== 'Pengguna Jasa') {
            return redirect()->route('dashboard')->with('error', 'Fitur wishlist hanya tersedia untuk Pengguna Jasa');
        }

        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('service.user')
            ->get();
            
        return view('wishlist', compact('wishlistItems'));
    }
    
    /**
     * Toggle wishlist (tambah jika belum ada, hapus jika sudah ada)
     */
    public function toggle(Request $request)
    {
        // Cek role pengguna
        if (Auth::user()->role !== 'Pengguna Jasa') {
            return response()->json([
                'success' => false,
                'message' => 'Fitur wishlist hanya tersedia untuk Pengguna Jasa'
            ], 403);
        }

        $serviceId = $request->service_id;
        
        // Cek apakah service ada
        $service = Service::find($serviceId);
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan tidak ditemukan'
            ], 404);
        }
        
        // Cek apakah sudah ada di wishlist
        $existingWishlist = Wishlist::where('user_id', Auth::id())
            ->where('service_id', $serviceId)
            ->first();
            
        if ($existingWishlist) {
            // Jika sudah ada, hapus dari wishlist
            $existingWishlist->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Layanan dihapus dari wishlist',
                'status' => 'removed'
            ]);
        } else {
            // Jika belum ada, tambahkan ke wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'service_id' => $serviceId
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Layanan ditambahkan ke wishlist',
                'status' => 'added'
            ]);
        }
    }

    /**
     * Menambahkan ke wishlist
     */
    public function add($id)
    {
        if (Auth::user()->role !== 'Pengguna Jasa') {
            return redirect()->back()->with('error', 'Fitur wishlist hanya tersedia untuk Pengguna Jasa');
        }

        $existingWishlist = Wishlist::where('user_id', Auth::id())
            ->where('service_id', $id)
            ->first();

        if (!$existingWishlist) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'service_id' => $id
            ]);
            return redirect()->back()->with('success', 'Layanan ditambahkan ke wishlist');
        }

        return redirect()->back()->with('info', 'Layanan sudah ada di wishlist');
    }

    /**
     * Menghapus dari wishlist
     */
    public function remove($id)
    {
        if (Auth::user()->role !== 'Pengguna Jasa') {
            return redirect()->back()->with('error', 'Fitur wishlist hanya tersedia untuk Pengguna Jasa');
        }

        $wishlist = Wishlist::where('service_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Layanan dihapus dari wishlist');
        }

        return redirect()->back()->with('error', 'Item wishlist tidak ditemukan');
    }
}