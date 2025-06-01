<?php

namespace App\Http\Controllers;

use App\Models\ReviewRating;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class ReviewRatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|min:10'
        ]);

        $pemesanan = Pemesanan::find($request->pemesanan_id);
        
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

        return redirect()->back()->with('success', 'Review berhasil ditambahkan');
    }

    public function edit($id)
    {
        $review = ReviewRating::findOrFail($id);
        
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
}
