@extends('main.layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Buat Postingan Baru</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="title">
                Judul
            </label>
            <input type="text" name="title" id="title"
                class="w-full border rounded p-2 @error('title') border-red-500 @enderror"
                value="{{ old('title') }}"
                placeholder="Masukkan judul postingan...">
            @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="category_id">
                Kategori
            </label>
            <select name="category_id" id="category_id"
                class="w-full border rounded p-2 @error('category_id') border-red-500 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2" for="body">
                Konten
            </label>
            <textarea name="body" id="body"
                class="w-full border rounded p-4 h-40 @error('body') border-red-500 @enderror"
                placeholder="Tulis isi postingan...">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Buat Postingan
        </button>
    </form>
</div>

@endsection