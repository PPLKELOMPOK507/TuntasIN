<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;

class SalesController extends Controller
{
    public function history()
    {
        // Controller
        $sales = Pemesanan::whereHas('jasa', function($q) {
            $q->where('user_id', auth()->id());
        })->with(['jasa', 'user', 'refunds'])->orderBy('created_at', 'desc')->get();

        return view('sales.history', ['sales' => $sales]);
    }
}