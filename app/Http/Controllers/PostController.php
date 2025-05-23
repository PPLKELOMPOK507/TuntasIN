<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Discussion;


class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts = Post::with('user', 'category', 'likes', 'comments')->latest()->get();
        $discussions = Discussion::with('user')->latest()->get(); // Tambahkan ini
        return view('main.posts.forum', compact('posts', 'categories', 'discussions'));
    }
    

    public function create()
    {
        $categories = Category::all();
        return view('main.posts.create-post', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'body' => 'required|string', // Gunakan 'body' jika tabel memiliki kolom 'body'
        ]);

        // Simpan data ke database
        Post::create([
            'title' => $validatedData['title'],
            'category_id' => $validatedData['category_id'],
            'body' => $validatedData['body'], // Gunakan 'body' jika tabel memiliki kolom 'body'
            'user_id' => Auth::id(), // Tambahkan user_id dari pengguna yang sedang login
        ]);

        // Redirect ke halaman lain dengan pesan sukses
        return redirect()->route('forum')->with('success', 'Postingan berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load('user', 'category', 'likes', 'comments');
        return view('main.posts.post-detail', compact('post'));
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $post->delete();
        return redirect()->route('forum')->with('success', 'Post deleted successfully.');
    }
    
    public function myComments()
    {
        $comments = Auth::user()->comments()->with('post')->latest()->get();
        return view('main.posts.my-comments', compact('comments')); 
    }

    public function myPosts()
    {
        $posts = Auth::user()->posts()->with('category', 'likes', 'comments')->latest()->get();
        return view('main.posts.my-posts', compact('posts'));
    }

    public function filterByCategory(Category $category)
    {
        $posts = Post::where('category_id', $category->id)
            ->with('user', 'category', 'likes', 'comments')
            ->latest()
            ->get();
    $categories = Category::all(); // Untuk menampilkan daftar kategori
    return view('main.posts.forum', compact('posts', 'categories', 'category'));
    }

    public function edit(Post $post)
    {
        // Pastikan hanya pemilik postingan yang dapat mengedit
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('main.posts.edit-post', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Pastikan hanya pemilik postingan yang dapat mengedit
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Perbarui postingan
        $post->update($validatedData);

        // Redirect ke halaman "My Posts"
        return redirect()->route('user.posts')->with('success', 'Post updated successfully!');
    }
}
