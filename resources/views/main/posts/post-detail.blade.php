@extends('main.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Tombol Back --}}
    <div class="mb-4">
        <a href="{{ route('forum') }}" class="inline-flex items-center text-gray-600 hover:text-blue-500 transition duration-150 ease-in-out text-lg font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Forum
        </a>
    </div>

    {{-- Post Detail dan Komentar --}}
    <div class="bg-white p-6 rounded shadow">
        {{-- Post Detail --}}
        <div class="mb-6">
            <div class="flex items-center mb-6">
                <img src="{{ asset('storage/'.$post->user->photo) }}" alt="User Photo" class="w-12 h-12 rounded-full object-cover mr-4">
                <div>
                    <span class="font-bold">{{ $post->user->first_name.' '.$post->user->last_name }}</span>
                    <p class="text-gray-600 text-sm">{{ $post->category->name }} - {{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
            <p class="text-gray-800">{{ $post->body }}</p>

            {{-- Like Button --}}
            <div class="mt-6 flex items-center space-x-4">
                <form method="POST" action="{{ route('post.like', $post) }}">
                    @csrf
                    <button type="submit" class="flex items-center text-gray-600 hover:text-blue-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : '' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                        </svg>
                        ({{ $post->likes->count() }}) Likes
                    </button>
                </form>
            </div>
        </div>

        {{-- Comments Section --}}
        <div>
            <h2 class="text-2xl font-bold mb-4">Comment</h2>

            {{-- Existing Comments --}}
            @if($post->comments && $post->comments->count() > 0)
                @foreach ($post->comments->where('parent_id', null) as $comment)
                    <div class="mb-6 border-b pb-4">
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('storage/'.$comment->user->photo) }}" alt="User Photo" class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-bold">{{ $comment->user->first_name.' '.$comment->user->last_name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="mt-2">{{ $comment->body }}</p>
                                <button onclick="toggleReplyForm('reply-form-{{ $comment->id }}')" class="text-blue-500 text-sm mt-2 hover:underline cursor-pointer">Reply</button>

                                {{-- Reply Form --}}
                                <form id="reply-form-{{ $comment->id }}" method="POST" action="{{ route('comments.store', $post) }}" class="hidden mt-2">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <textarea name="body" class="w-full border rounded p-2 mt-2" placeholder="Reply Comment..."></textarea>
                                    <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded">Send Reply</button>
                                </form>

                                {{-- Replies --}}
                                @if($comment->replies && $comment->replies->count() > 0)
                                    @foreach ($comment->replies as $reply)
                                        <div class="flex items-start gap-4 mt-4 ml-8">
                                            <img src="{{ asset('storage/'.$reply->user->photo) }}" alt="Reply User Photo" class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <p class="font-bold">{{ $reply->user->first_name.' '.$reply->user->last_name }}</p>
                                                    <p class="text-gray-400 text-xs">{{ $reply->created_at->diffForHumans() }}</p>
                                                </div>
                                                <p class="mt-1">{{ $reply->body }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- New Comment Form --}}
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6">
                @csrf
                <textarea name="body" class="w-full border rounded p-4" placeholder="Write a new comment..."></textarea>
                <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded cursor-pointer">Send Comment</button>
            </form>
        </div>
    </div>
</div>

{{-- Toggle Reply Form Script --}}
<script>
    function toggleReplyForm(id) {
        const form = document.getElementById(id);
        form.classList.toggle('hidden');
    }
</script>
@endsection
