<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    // Menampilkan daftar diskusi
    public function index()
    {
        $discussions = Discussion::latest()->paginate(10); // Pagination untuk daftar diskusi
        return view('main.posts.discussions', compact('discussions'));
    }

    // Menampilkan halaman untuk membuat diskusi baru
    public function create()
    {
        return view('main.posts.create-discussion'); // Buat view baru untuk diskusi
    }

    // Menyimpan diskusi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Discussion::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('forum.index')->with('success', 'Discussion created successfully!');
    }

    // Menampilkan detail diskusi
    public function show($id)
    {
        $discussion = Discussion::findOrFail($id);
        return view('main.posts.show-discussion', compact('discussion'));
    }

    // Menghapus diskusi
    public function destroy($id)
    {
        $discussion = Discussion::findOrFail($id);

        if ($discussion->user_id !== auth()->id()) {
            return redirect()->route('forum.index')->with('error', 'You are not authorized to delete this discussion.');
        }

        $discussion->delete();

        return redirect()->route('forum.index')->with('success', 'Discussion deleted successfully!');
    }
}