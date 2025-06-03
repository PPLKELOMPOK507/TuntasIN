<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;

class SalesController extends Controller
{
    public function history()
    {
        $sales = Pemesanan::whereHas('jasa', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['jasa', 'user', 'payment', 'refunds'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('sales.history', compact('sales'));
    }
}