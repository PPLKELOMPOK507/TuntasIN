<?php
// filepath: c:\Users\YOGA\Documents\GitHub\TuntasIN\app\Http\Controllers\CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('addCategory');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('editCategory', compact('category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($validated);

        return redirect()->route('manage')
            ->with('success', 'Kategori berhasil ditambahkan!')
            ->with('activeTab', 'categories'); // Tambahkan ini
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id
        ]);

        $category->update($validated);
        
        return redirect()->route('manage')
            ->with('success', 'Kategori berhasil diperbarui!')
            ->with('activeTab', 'categories'); // Tambahkan ini
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has services
        if ($category->services()->count() > 0) {
            return redirect()->route('manage')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki jasa terkait.')
                ->with('activeTab', 'categories'); // Tambahkan ini
        }

        $category->delete();
        
        return redirect()->route('manage')
            ->with('success', 'Kategori berhasil dihapus!')
            ->with('activeTab', 'categories'); // Tambahkan ini
    }
}