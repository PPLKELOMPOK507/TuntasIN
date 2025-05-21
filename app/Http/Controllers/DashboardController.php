<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    $query = Jasa::query();

    if ($request->filled('search')) {
        $query->where('nama_jasa', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category')) {
        $query->where('kategori', $request->category);
    }

    $jasa = $query->get();

    return view('dashboard', compact('jasa'));
    }
}
