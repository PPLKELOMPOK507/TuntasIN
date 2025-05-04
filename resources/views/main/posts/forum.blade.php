@extends('main.layouts.app')

@section('content')
    <div class="grid grid-cols-4 gap-10">
        <div class="col-span-3 flex flex-col">
            {{-- category --}}
            <div class="flex flex-col bg-white rounded-md p-4 mb-4">
                <div class="col-span-1">
                    <h1 class="font-bold text-2xl">Category</h1>
                </div>
                @if($categories->isEmpty())
                    <h1 class="font-semibold text-xl">No Category yet!</h1>
                @else
                    <div class="grid grid-cols-6 items-center justify-center gap-2 mt-4">
                        @foreach($categories as $category)
                            <div class="flex items-center border-2 rounded-lg px-4 hover:bg-black hover:text-white transition duration-200 ease-in-out cursor-pointer py-2">
                                {{ $category->name }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- post --}}
            <div class="flex flex-col bg-white rounded-md p-4 gap-4">
                <h1 class="font-bold text-2xl">Posts</h1>
                @if($posts->isEmpty())
                    <h1 class="font-semibold text-xl">No Post yet!</h1>
                @else
                    @foreach ($posts as $post)
                        <div class="w-full py-2 px-4 border-t-2 border-b-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('storage/'.$post->user->photo) }}" alt="author-image" class="w-10 h-10 rounded-full object-cover">
                                <div class="flex flex-col">
                                    <a class="font-semibold text-md hover:underline cursor-pointer" href="{{ route('post.show', $post->id) }}">
                                        {{-- post title --}}
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
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : 'hover:text-blue-500' }} transition duration-200 ease-in-out cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                        </svg>
                                        {{ $post->likes->count() }} Likes
                                    </button>
                                </form>
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                    </svg>
                                    {{ $post->comments->count() }} comments  
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-start-4 flex flex-col gap-4">
            <a href="{{ route('forum.create') }}" class="w-full ">
                {{-- create post --}}
                <button class="w-full flex items-center justify-center gap-2 py-2 bg-black rounded-lg text-white font-semibold hover:bg-black/80 transition duration-200 ease-in-out cursor-pointer">
                    <i class="bi bi-plus-lg text-2xl"></i>
                    Create a post
                </button>
            </a>
            <div class="flex flex-col bg-white shadow-lg rounded-md p-4 gap-4">
                <span class="text-gray-400">Me</span>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-10 h-10 rounded-full object-cover" alt="">
                    <div class="flex flex-col">
                        <span class="font-semibold text-md">{{ auth()->user()->full_name }}</span>
                        <span class="text-gray-400 text-sm">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                <div class="flex items-center p-2 justify-between gap-2">
                    <span class="font-semibold">My Posts</span>
                    <i class="bi bi-chevron-right font-bold cursor-pointer"></i>
                </div>
                <div class="flex items-center p-2 justify-between gap-2">
                    <span class="font-semibold">My Comments</span>
                    <i class="bi bi-chevron-right font-bold cursor-pointer"></i>
                </div>
            </div>
        </div>
    </div>
@endsection