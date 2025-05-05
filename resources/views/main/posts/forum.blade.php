@extends('main.layouts.app')

@section('content')
    {{-- Tombol Back --}}
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <div class="text-2xl font-bold text-blue-500">
            Community
        </div>
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-600 text-sm font-medium rounded-full hover:bg-gray-100 transition duration-150 ease-in-out">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </a>
        </div>
    </nav>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-4 gap-10 mt-6">
        {{-- Bagian Kiri --}}
        <div class="col-span-3 flex flex-col space-y-6">
            {{-- Kategori --}}
            <div class="flex flex-col bg-white rounded-md p-4 shadow-md">
                <h1 class="font-bold text-xl mb-4">Category</h1>
                @if($categories->isEmpty())
                    <h1 class="font-semibold text-xl">No Category yet!</h1>
                @else
                    <div class="grid grid-cols-6 gap-4">
                        @foreach($categories as $category)
                            <a href="{{ route('forum.category', $category->id) }}" 
                               class="flex items-center border-2 rounded-full px-4 py-2 
                               {{ isset($currentCategory) && $currentCategory->id === $category->id ? 'bg-[#4285F4] text-white border-[#4285F4]' : 'bg-blue-50 text-gray-600 border-gray-300 hover:bg-blue-100 hover:text-gray-800' }} 
                               transition duration-200 ease-in-out cursor-pointer">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Postingan --}}
            <div class="flex flex-col bg-white rounded-md p-4 shadow-md">
                <h1 class="font-bold text-xl mb-4">
                    Thread
                </h1>
                @if($posts->isEmpty())
                    <div class="flex flex-col items-center justify-center gap-4">
                        <img src="{{ asset('images/no-posts.png') }}" alt="No Posts" class="w-32 h-32">
                        <h1 class="font-semibold text-xl">No Post yet!</h1>
                        <p class="text-gray-500">Be the first to create a post in this category</p>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="w-full py-4 px-4 border-t border-b flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/'.$post->user->photo) }}" alt="author-image" class="w-10 h-10 rounded-full object-cover">
                                <div class="flex flex-col">
                                    <a class="font-semibold text-md hover:underline cursor-pointer" href="{{ route('post.show', $post->id) }}">
                                        {{ $post->title }}
                                    </a>
                                    <span class="text-gray-400 text-sm">
                                        {{ $post->user->full_name }} - {{ $post->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <form action="{{ route('post.like', $post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-1">
                                        <i class="bi bi-hand-thumbs-up {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : 'hover:text-blue-500' }}"></i>
                                        {{ $post->likes->count() }} Likes
                                    </button>
                                </form>
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-chat"></i>
                                    {{ $post->comments->count() }} comments
                                </span>
                                @if(auth()->id() === $post->user_id)
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition duration-200 ease-in-out">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Placeholder Discussion Forum --}}
            <div class="flex flex-col bg-white rounded-md p-6 shadow-md mt-6">
                <h1 class="font-bold text-xl mb-4">Discussion Forum</h1>
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="{{ asset('images/discussion-forum-logo.jpg') }}" alt="Discussion Forum Logo" class="w-32 h-32 object-contain">
                    <h1 class="font-semibold text-xl">No Discussions yet!</h1>
                    <p class="text-gray-500">Be the first to start a discussion in this forum</p>
                    <a href="{{ route('forum.create') }}" class="px-6 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                        Start a Discussion
                    </a>
                </div>
            </div>
        </div>

        {{-- Bagian Kanan --}}
        <div class="col-span-1 flex flex-col space-y-6">
            {{-- Tombol Buat Post --}}
            <a href="{{ route('forum.create') }}" class="w-full">
                <button class="w-full flex items-center justify-center gap-2 py-2 bg-blue-500 rounded-lg text-white font-semibold hover:bg-blue-600 transition duration-200 ease-in-out cursor-pointer">
                    <i class="bi bi-plus-lg text-2xl"></i>
                    Create a post
                </button>
            </a>

            {{-- Informasi Pengguna --}}
            <div class="flex flex-col bg-white shadow-lg rounded-md p-4">
                <div class="flex items-center gap-4 mt-4">
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-12 h-12 rounded-full object-cover" alt="">
                    <div class="flex flex-col">
                        <span class="font-semibold text-md">{{ auth()->user()->full_name }}</span>
                        <span class="text-gray-400 text-sm">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('user.posts') }}" class="flex items-center justify-between text-gray-600 hover:text-gray-800 transition duration-150 ease-in-out">
                        <span>My Posts</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('user.comments') }}" class="flex items-center justify-between text-gray-600 hover:text-gray-800 transition duration-150 ease-in-out mt-2">
                        <span>My Comments</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            {{-- Community Rules --}}
            <div class="flex flex-col bg-white shadow-lg rounded-md p-4 space-y-4">
                <h2 class="font-bold text-lg">Community rules</h2>
                <div class="flex flex-col space-y-2">
                    {{-- Rule 1 --}}
                    <button class="w-full text-left font-medium text-gray-600 hover:text-gray-800 flex justify-between items-center" onclick="toggleRule('rule1')">
                        No Offensive Content
                        <i id="arrow-rule1" class="bi bi-chevron-down transition-transform"></i>
                    </button>
                    <p id="rule1" class="hidden text-sm text-gray-500 mt-2">
                        Do not post "offensive" posts or links. Any material which constitutes defamation, harassment, or abuse is strictly prohibited. Material that is sexually or otherwise obscene, racist, or overly discriminatory is not permitted. Any violations will lead to an immediate ban.
                    </p>
                    <hr class="my-2 border-gray-300">

                    {{-- Rule 2 --}}
                    <button class="w-full text-left font-medium text-gray-600 hover:text-gray-800 flex justify-between items-center" onclick="toggleRule('rule2')">
                        No Spam or Advertising
                        <i id="arrow-rule2" class="bi bi-chevron-down transition-transform"></i>
                    </button>
                    <p id="rule2" class="hidden text-sm text-gray-500 mt-2">
                        We define spam as unsolicited advertisement for goods, services and/or other websites, or posts with little, or completely unrelated content. Do not spam the forum with links to your site or product, or try to self-promote your website, business or forum etc.
                    </p>
                    <hr class="my-2 border-gray-300">

                    {{-- Rule 3 --}}
                    <button class="w-full text-left font-medium text-gray-600 hover:text-gray-800 flex justify-between items-center" onclick="toggleRule('rule3')">
                        No Illegal Activity
                        <i id="arrow-rule3" class="bi bi-chevron-down transition-transform"></i>
                    </button>
                    <p id="rule3" class="hidden text-sm text-gray-500 mt-2">
                        Posts suggesting, seeking advice about, or otherwise promoting illegal activity are not permitted. This includes posts containing or seeking copyright infringing material.
                    </p>
                    <hr class="my-2 border-gray-300">

                    {{-- Rule 4 --}}
                    <button class="w-full text-left font-medium text-gray-600 hover:text-gray-800 flex justify-between items-center" onclick="toggleRule('rule4')">
                        Be Respectful
                        <i id="arrow-rule4" class="bi bi-chevron-down transition-transform"></i>
                    </button>
                    <p id="rule4" class="hidden text-sm text-gray-500 mt-2">
                        All posts should be professional and courteous. You have every right to disagree with your fellow community members and explain your perspective. However, you are not free to attack, degrade, insult, or otherwise belittle others.
                    </p>
                </div>

                {{-- Footer Links --}}
                <div class="text-sm text-gray-500 mt-4 flex justify-between">
                    <a href="#" class="hover:underline">Terms of Policy</a>
                    <a href="#" class="hover:underline">Code of Conduct</a>
                    <a href="#" class="hover:underline">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    function toggleRule(id) {
        const rule = document.getElementById(id);
        const arrow = document.getElementById(`arrow-${id}`);
        if (rule.classList.contains('hidden')) {
            rule.classList.remove('hidden');
            arrow.classList.add('rotate-180'); // Memutar panah ke atas
        } else {
            rule.classList.add('hidden');
            arrow.classList.remove('rotate-180'); // Memutar panah ke bawah
        }
    }
    </script>
@endsection