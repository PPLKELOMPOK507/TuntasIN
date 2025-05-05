@extends('main.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-bold text-2xl">My Posts</h1>
        {{-- Tombol Back to Forum --}}
        <a href="{{ route('forum') }}" class="inline-flex items-center text-black hover:text-gray-700 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Forum
        </a>
    </div>

    @if($posts->isEmpty())
        <div class="text-center mt-10">
            {{-- Kotak Putih --}}
            <div class="bg-white p-6 rounded-md shadow-md inline-block">
                {{-- Icon --}}
                <div class="flex justify-center mb-4">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75h-9a3 3 0 00-3 3v10.5a3 3 0 003 3h9a3 3 0 003-3V6.75a3 3 0 00-3-3zM9 7.5h6M9 12h6m-6 4.5h3" />
                        </svg>
                    </div>
                </div>
                {{-- Message --}}
                <p class="text-gray-500 font-semibold text-lg">No posts yet!</p>
                <p class="text-gray-400">Looks like you haven't created any posts. Start writing your first post to get started.</p>
            </div>
        </div>
    @else
        @foreach($posts as $post)
            <div class="bg-white p-4 rounded-md shadow mb-4">
                {{-- Judul Post --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('post.show', $post->id) }}" class="font-semibold text-lg hover:underline">
                        {{ $post->title }}
                    </a>
                    <div class="flex items-center space-x-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('post.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="bi bi-pencil"></i>
                        </a>
                        {{-- Tombol Hapus --}}
                        <form method="POST" action="{{ route('post.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Informasi Post --}}
                <div class="text-gray-500 text-sm mt-2 flex items-center space-x-4">
                    <span><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                    <span><i class="bi bi-chat"></i> {{ $post->comments->count() }} comments</span>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded">
                        {{ $post->status }}
                    </span>
                </div>
            </div>
        @endforeach
    @endif
@endsection