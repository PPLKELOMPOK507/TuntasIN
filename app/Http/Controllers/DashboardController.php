<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Category; // Add this import
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
            $query->where('category_id', $request->category);
        }

        $jasa = $query->get();
        $categories = Category::all(); // Add this line

        return view('dashboard', compact('jasa', 'categories'));
    }
}
