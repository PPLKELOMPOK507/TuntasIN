<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function history()
    {
        $sales = auth()->user()->sales()->latest()->get();
        return view('sales.history', compact('sales'));
    }
}