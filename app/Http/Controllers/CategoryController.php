<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        // Change from 'addCategory' to 'addCategories'
        return view('addCategories');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->services()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki jasa terkait.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}