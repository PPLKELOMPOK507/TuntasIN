<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts = Post::with('user', 'category', 'likes', 'comments')->latest()->get();
        return view('main.posts.forum', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('main.posts.create-post', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('forum')->with('success', 'Post created successfully.');
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
}
