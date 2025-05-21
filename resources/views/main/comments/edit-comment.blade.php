@extends('main.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="font-bold text-2xl mb-6">Edit Comment</h1>

    <form method="POST" action="{{ route('comment.update', $comment->id) }}">
        @csrf
        @method('PUT')

        {{-- Komentar --}}
        <div class="mb-4">
            <label for="body" class="block text-sm font-medium text-gray-700">Comment</label>
            <textarea name="body" id="body" 
                      class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('body') border-red-500 @enderror"
                      rows="4">{{ old('body', $comment->body) }}</textarea>
            @error('body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Update Comment
        </button>
    </form>
</div>
@endsection