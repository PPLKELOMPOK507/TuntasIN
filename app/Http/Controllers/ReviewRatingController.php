<?php

namespace App\Http\Controllers;

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

        ReviewRating::create([
            'user_id' => auth()->id(),
            'jasa_id' => $pemesanan->jasa_id,
            'pemesanan_id' => $pemesanan->id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->back()->with('success', 'Review berhasil ditambahkan');
    }
}
