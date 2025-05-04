@extends('main.layouts.app')

@section('content')
    <h1 class="font-bold text-2xl mb-4">My Posts</h1>
    @if($posts->isEmpty())
        <p>No posts yet!</p>
    @else
        @foreach($posts as $post)
            <div class="border-b py-2">
                <a href="{{ route('post.show', $post->id) }}" class="font-semibold hover:underline">{{ $post->title }}</a>
                <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    @endif
@endsection