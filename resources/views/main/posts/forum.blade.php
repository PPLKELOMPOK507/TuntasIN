@extends('main.layouts.app')

@section('content')
    {{-- Navbar --}}
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <div class="text-2xl font-bold text-blue-500">
            Community
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-600 text-sm font-medium rounded-full hover:bg-gray-100 transition">
                <i class="bi bi-arrow-left mr-2"></i> Back
            </a>
        </div>
    </nav>

    {{-- Main Grid --}}
    <div class="grid grid-cols-4 gap-10 mt-6 px-6">
        {{-- Main Content --}}
        <div class="col-span-3 space-y-6">

            {{-- Categories --}}
            <div class="bg-white rounded-md p-4 shadow-md">
                <h1 class="font-bold text-xl mb-4">Category</h1>
                @forelse ($categories as $category)
                    <a href="{{ route('forum.category', $category->id) }}" 
                       class="inline-flex items-center border-2 rounded-full px-4 py-2 mb-2
                       {{ isset($currentCategory) && $currentCategory->id === $category->id ? 'bg-blue-600 text-white border-blue-600' : 'bg-blue-50 text-gray-600 border-gray-300 hover:bg-blue-100' }} 
                       transition">
                        {{ $category->name }}
                    </a>
                @empty
                    <p class="text-gray-500">No categories available.</p>
                @endforelse
            </div>

            {{-- Posts --}}
            <div class="bg-white rounded-md p-4 shadow-md">
                <h1 class="font-bold text-xl mb-4">Recent Posts</h1>
                @forelse ($posts as $post)
                    <div class="border-t py-4 flex justify-between items-start">
                        <div class="flex gap-4">
                            <img src="{{ asset('storage/'.$post->user->photo) }}" alt="User" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <a href="{{ route('posts.show', $post->id) }}" class="text-md font-semibold hover:underline">{{ $post->title }}</a>
                                <p class="text-sm text-gray-500">
                                    {{ $post->user->name }} • {{ $post->category->name }} • {{ $post->created_at->diffForHumans() }}
                                </p>
                                <p class="mt-2 text-gray-700">{{ Str::limit($post->content, 100) }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2 text-sm text-gray-600">
                            <form action="{{ route('post.like', $post->id) }}" method="POST">
                                @csrf
                                <button class="flex items-center gap-1">
                                    <i class="bi bi-hand-thumbs-up {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : '' }}"></i>
                                    {{ $post->likes->count() }} Likes
                                </button>
                            </form>
                            <span class="flex items-center gap-1">
                                <i class="bi bi-chat"></i>
                                {{ $post->comments->count() }} Comments
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <img src="{{ asset('images/no-posts.png') }}" alt="No posts" class="mx-auto w-32 h-32">
                        <p class="font-semibold text-lg mt-4">No Post yet!</p>
                        <p class="text-gray-500">Be the first to create a post in this category</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-span-1 space-y-6">
            {{-- Create Post Button --}}
            <a href="{{ route('forum.create') }}" class="block">
                <button class="w-full flex items-center justify-center gap-2 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                    <i class="bi bi-plus-lg text-xl"></i>
                    Create a post
                </button>
            </a>

            {{-- User Info --}}
            <div class="bg-white rounded-md p-4 shadow-md">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-semibold">{{ auth()->user()->full_name }}</p>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('user.posts') }}" class="flex justify-between text-gray-600 hover:text-gray-800">
                        My Posts <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('user.comments') }}" class="flex justify-between text-gray-600 hover:text-gray-800">
                        My Comments <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>

            {{-- Community Rules --}}
            <div class="bg-white rounded-md p-4 shadow-md">
                <h2 class="font-bold text-lg mb-4">Community Rules</h2>
                @foreach ([
                    'No Offensive Content' => 'Do not post “offensive” posts or links. Any material which constitutes defamation, harassment, or abuse is strictly prohibited. Material that is sexually or otherwise obscene, racist, or otherwise overly discriminatory is not permitted. Any violations will lead to an immediate ban.',
                    'No Spam or Advertising' => 'We define spam as unsolicited advertisement for goods, services and/or other web sites, or posts with little, or completely unrelated content. Do not spam the forum with links to your site or product, or try to self-promote your website, business or forum etc.',
                    'No Illegal Activity' => 'Posts suggesting, seeking advice about, or otherwise promoting illegal activity are not permitted. This includes posts containing or seeking copyright infringing material.',
                    'Be Respectful' => 'All posts should be professional and courteous. You have every right to disagree with your fellow community members and explain your perspective. However, you are not free to attack, degrade, insult, or otherwise belittle others.'
                ] as $title => $description)
                    <div>
                        <button class="w-full text-left text-gray-600 font-medium hover:text-gray-800 flex justify-between items-center" onclick="toggleRule('{{ Str::slug($title) }}')">
                            {{ $title }}
                            <i id="arrow-{{ Str::slug($title) }}" class="bi bi-chevron-down transition-transform"></i>
                        </button>
                        <p id="{{ Str::slug($title) }}" class="hidden text-sm text-gray-500 mt-2">{{ $description }}</p>
                        <hr class="my-2">
                    </div>
                @endforeach

                <div class="text-sm text-gray-500 mt-4 flex justify-between">
                    <a href="#" class="hover:underline">Terms</a>
                    <a href="#" class="hover:underline">Conduct</a>
                    <a href="#" class="hover:underline">Privacy</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Toggle Script --}}
    <script>
        function toggleRule(id) {
            const rule = document.getElementById(id);
            const arrow = document.getElementById(`arrow-${id}`);
            rule.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
@endsection
