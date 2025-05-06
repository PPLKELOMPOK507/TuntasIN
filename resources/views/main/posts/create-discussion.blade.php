@extends('main.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white rounded-md shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Create New Discussion</h1>
            <a href="{{ route('forum.index') }}" class="text-blue-500 hover:underline flex items-center">
                ← Back to Forum
            </a>
        </div>
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
            <strong>Tips for Creating Engaging Discussions:</strong>
            <p>Use clear titles and detailed descriptions to encourage participation and engagement.</p>
        </div>
        <form action="{{ route('discussion.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" placeholder="Add an Attractive and Informative Title..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="5" placeholder="Write the content of the discussion..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required></textarea>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                Publish Discussion
            </button>
        </form>
    </div>
</div>
@endsection