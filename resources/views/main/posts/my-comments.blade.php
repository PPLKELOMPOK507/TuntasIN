@extends('main.layouts.app')

@section('content')
    <h1 class="font-bold text-2xl mb-4">My Comments</h1>
    @if($comments->isEmpty())
        <p>No comments yet!</p>
    @else
        @foreach($comments as $comment)
            <div class="border-b py-2">
                <p>{{ $comment->body }}</p>
                <p class="text-gray-500 text-sm">On post: <a href="{{ route('post.show', $comment->post->id) }}" class="hover:underline">{{ $comment->post->title }}</a></p>
                <p class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    @endif
@endsection