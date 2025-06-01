<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\ReviewRating;

class ReviewRatingController extends Controller
{
    public function store(Request $request, $pemesanan_id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|min:10'
        ]);

        $pemesanan = Pemesanan::findOrFail($pemesanan_id);
        
        // Cek apakah pesanan milik user yang login
        if ($pemesanan->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        // Cek apakah sudah ada review
        if ($pemesanan->hasReview()->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review');
        }

        ReviewRating::create([
            'user_id' => auth()->id(),
            'jasa_id' => $pemesanan->jasa_id,
            'pemesanan_id' => $pemesanan->id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->route('purchases.history')->with('success', 'Review berhasil ditambahkan');
    }

    public function edit($id)
    {
        $review = ReviewRating::with(['jasa', 'pemesanan'])->findOrFail($id);
        
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = ReviewRating::findOrFail($id);
        
        if ($review->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|min:10'
        ]);

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->route('purchases.history')->with('success', 'Review berhasil diperbarui');
    }
    
    public function create($pemesanan_id)
    {
        try {
            $pemesanan = Pemesanan::with(['jasa', 'jasa.user'])->findOrFail($pemesanan_id);
            
            if ($pemesanan->user_id !== auth()->id()) {
                return redirect()->route('purchases.history')->with('error', 'Unauthorized access');
            }

            if ($pemesanan->hasReview()->exists()) {
                return redirect()->route('purchases.history')->with('error', 'Anda sudah memberikan review');
            }

            return view('reviews.createReview', compact('pemesanan'));
            
        } catch (\Exception $e) {
            \Log::error('Review creation error: ' . $e->getMessage());
            return redirect()->route('purchases.history')->with('error', 'Terjadi kesalahan saat membuka form review');
        }
    }
}
