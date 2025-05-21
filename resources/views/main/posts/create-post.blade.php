@extends('main.layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5f9ff] p-8">
    {{-- Header dan Tips --}}
    <div class="bg-white rounded-md shadow-md p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            {{-- Ikon dan Judul --}}
            <div class="flex items-center gap-2">
                <div class="bg-blue-100 p-2 rounded-full">
                    <i class="bi bi-pencil text-blue-600 text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Thread</h1>
            </div>

            {{-- Tombol Kembali --}}
            <a href="{{ route('forum') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-600 text-sm font-medium rounded-full hover:bg-gray-100 transition duration-150 ease-in-out">
                <i class="bi bi-arrow-left mr-2"></i> Back to Forum
            </a>
        </div>

        {{-- Tips --}}
        <div class="bg-green-100 border border-green-300 text-green-800 text-sm rounded-md p-4">
            <i class="bi bi-info-circle-fill mr-2"></i>
            <strong>Tips for Creating Engaging Posts</strong><br>
            Posts with clear titles and detailed descriptions receive 70% more engagement. Be sure to tell what you need for the best outcomes.
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 text-sm rounded-md p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('posts.store') }}" class="bg-white rounded-md shadow-md p-6 space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" 
                   class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                   value="{{ old('title') }}"
                   placeholder="Add an Attractive and Informative Title...">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" id="category_id" 
                    class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                <option value="" disabled selected>Choose Category...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konten --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2" for="body">
                Content
            </label>
            <textarea name="body" id="body"
                class="w-full border rounded p-4 h-40 @error('body') border-red-500 @enderror"
                placeholder="Write the content of the post...">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                Publish Post
            </button>
        </div>
    </form>
</div>
@endsection