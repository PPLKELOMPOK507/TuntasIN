<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        if ($post->likes()->where('user_id', auth()->id())->exists()) {
            $post->likes()->detach(auth()->id());
        } else {
            $post->likes()->attach(auth()->id());
        }

        return back();
    }
}
