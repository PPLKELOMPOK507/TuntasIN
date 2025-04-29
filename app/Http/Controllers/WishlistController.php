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
     * Menghapusan dari wishlist
     */
    public function remove(Request $request)
    {
        $wishlistId = $request->wishlist_id;
        
        $wishlist = Wishlist::where('id', $wishlistId)
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Item wishlist tidak ditemukan'
            ], 404);
        }
        
        $wishlist->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil dihapus dari wishlist'
        ]);
    }
}