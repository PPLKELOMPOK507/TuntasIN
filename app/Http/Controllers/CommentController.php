<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function edit(Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang dapat mengedit
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('main.comments.edit-comment', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang dapat mengedit
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi data
        $validatedData = $request->validate([
            'body' => 'required|string|max:500',
        ]);

        // Perbarui komentar
        $comment->update($validatedData);

        return redirect()->route('user.comments')->with('success', 'Comment updated successfully!');
    }

    public function myComments()
    {
        // Ambil komentar milik pengguna yang sedang login
        $comments = Comment::where('user_id', auth()->id())->with('post')->latest()->get();

        // Tampilkan view dengan komentar
        return view('main.posts.my-comments', compact('comments'));
    }

    public function destroy(Comment $comment)
    {
        // Pastikan hanya pemilik komentar yang dapat menghapus
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus komentar
        $comment->delete();

        // Redirect ke halaman "My Comments" dengan pesan sukses
        return redirect()->route('user.comments')->with('success', 'Comment deleted successfully!');
    }
}
