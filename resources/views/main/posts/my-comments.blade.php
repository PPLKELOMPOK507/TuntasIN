@extends('main.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-bold text-2xl">My Comments</h1>
        {{-- Tombol Back to Forum --}}
        <a href="{{ route('forum') }}" class="inline-flex items-center text-black hover:text-gray-700 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Forum
        </a>
    </div>

    @if($comments->isEmpty())
        <p>No comments yet!</p>
    @else
        @foreach($comments as $comment)
            <div class="bg-white p-4 rounded-md shadow mb-4">
                {{-- Isi Komentar --}}
                <p class="text-gray-800">{{ $comment->body }}</p>

                {{-- Informasi Post --}}
                <p class="text-gray-500 text-sm mt-2">
                    On post: 
                    <a href="{{ route('post.show', $comment->post->id) }}" class="text-blue-500 hover:underline">
                        {{ $comment->post->title }}
                    </a>
                </p>

                {{-- Informasi User --}}
                @if($comment->user)
                    <p class="text-gray-500 text-sm mt-1">
                        By: {{ $comment->user->name }}
                    </p>
                @else
                    <p class="text-gray-500 text-sm mt-1">
                        By: Unknown User
                    </p>
                @endif

                {{-- Waktu Komentar --}}
                <p class="text-gray-500 text-sm flex items-center mt-1">
                    <i class="bi bi-clock mr-1"></i> {{ $comment->created_at->diffForHumans() }}
                </p>

                {{-- Tombol Edit dan Delete --}}
                <div class="flex items-center space-x-4 mt-4">
                    {{-- Tombol Edit --}}
                    <a href="{{ route('comment.edit', $comment->id) }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                        <i class="bi bi-pencil mr-1"></i> Edit
                    </a>

                    {{-- Tombol Delete --}}
                    <form method="POST" action="{{ route('comment.destroy', $comment->id) }}" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                            <i class="bi bi-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
@endsection