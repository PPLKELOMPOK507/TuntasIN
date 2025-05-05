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
        <div class="flex justify-center mt-10">
            {{-- Kotak Putih --}}
            <div class="bg-white p-10 rounded-md shadow-md w-full max-w-4xl">
                {{-- Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-12 h-12 text-teal-500">
                            <path d="M12 3C7.031 3 3 5.238 3 8v8c0 2.762 4.031 5 9 5s9-2.238 9-5V8c0-2.762-4.031-5-9-5zm0 16c-4.411 0-8-1.794-8-4V8c0-2.206 3.589-4 8-4s8 1.794 8 4v7c0 2.206-3.589 4-8 4zm-3-7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3zm3 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3zm3 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 1 1 0 3z"/>
                        </svg>
                    </div>
                </div>
                {{-- Message --}}
                <p class="text-gray-500 font-semibold text-lg text-center">No comments yet!</p>
                <p class="text-gray-400 text-center">You haven't made any comments yet. Engage with posts to start conversations and see your comments here.</p>
            </div>
        </div>
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