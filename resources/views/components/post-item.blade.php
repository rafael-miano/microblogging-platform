@php
    $hasUpReact = isset($userUpReactedPostIds) && in_array($post->id, $userUpReactedPostIds);
@endphp

<div class="flex bg-white border border-gray-200 rounded-lg shadow-sm mb-8">
    <div class="p-5 flex-1">
        <a href="{{ route('post.show', ['username' => $post->user->username, 'post' => $post->slug]) }}">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                {{ $post->title }}
            </h5>
        </a>
        <div class="prose mb-3 font-normal text-gray-700">
            {!! $post->excerpt(25) !!}
        </div>
        <div class="text-sm text-gray-400 flex gap-4">
            <div>
                by
                <a href="{{ route('profile.show', $post->user->username) }}" class="text-gray-600 hover:underline">
                    {{ $post->user->username }}
                </a>
                at
                @if ($post->published_at == null)
                    {{ $post->created_at->format('M d, Y') }}
                @else
                    {{ $post->published_at->format('M d, Y') }}
                @endif
            </div>

            <span class="inline-flex gap-1 items-center">
                @auth
                    <span class="inline-flex gap-1 items-center">
                        @if ($hasUpReact)
                            <x-bxs-upvote class="w-4 h-4 text-gray-600" />
                        @else
                            <x-bx-upvote class="w-4 h-4 text-gray-500" />
                        @endif
                        {{ $post->up_reacts_count }}
                    </span>
                @else
                    <span class="inline-flex gap-1 items-center">
                        <x-bx-upvote class="w-4 h-4 text-gray-400" />
                        {{ $post->up_reacts_count }}
                    </span>
                @endauth
            </span>
        </div>
    </div>
    <a href="{{ route('post.show', ['username' => $post->user->username, 'post' => $post->slug]) }}">
        <img class="w-48 h-full max-h-64 object-cover rounded-r-lg" src="{{ $post->imageUrl() }}" alt="" />
    </a>
</div>
