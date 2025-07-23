<x-app-layout>
    <div class="py-4">
        <div class="max-w-[900px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-4xl mb-4 font-semibold">{{ $post->title }}</h1>
                {{-- User Avatar Section --}}
                <div class="flex gap-4 items-center">
                    <x-user-avatar :user="$post->user" />
                    <div>
                        <x-follow-ctr :user="$post->user" class="flex">
                            <a href="{{ route('profile.show', $post->user) }}">
                                {{ $post->user->name }}
                            </a>
                            @auth
                                @if (auth()->id() !== $post->user_id)
                                    &middot;
                                    <button 
                                        @click="follow()" 
                                        x-text="following ? 'Unfollow' : 'Follow'"
                                        :class="following ? 'text-md text-gray-600' : 'text-md text-green-600'">
                                    </button>
                                @endif
                            @endauth
                            <div class="flex text-sm text-gray-500">
                                {{ $post->readTime() }} min read &middot;
                                @if ($post->published_at == null)
                                    {{ $post->created_at->format('M d, Y') }}
                                @else
                                    {{ $post->published_at->format('M d, Y') }}
                                @endif

                            </div>
                        </x-follow-ctr>

                    </div>
                </div>
                {{-- Up React Section --}}
                <div class="mt-4 border-b flex justify-between items-center pb-4">
                    <x-up-react-button :post="$post" :hasUpReact="$hasUpReact" />

                    @if ($post->user_id === Auth::id())
                        <div class="flex gap-2">
                            <a href="{{ route('post.edit', $post->slug) }}">
                                <x-primary-button>Edit</x-primary-button></a>

                            <form class="inline-block" action="{{ route('post.destroy', $post) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>
                                    Delete
                                </x-danger-button>
                            </form>
                        </div>
                    @endif
                </div>


                {{-- Post Content --}}
                <div>
                    <img src="{{ $post->imageUrl() }}" alt="Post Image" class="mt-4 w-full">
                    <div class="prose max-w-none mt-4 copy-code-enabled">
                        {!! $post->content_html !!}
                    </div>
                </div>

                {{-- Category Badge Section --}}
                <div class="mt-4">
                    <span class="px-4 py-2 bg-gray-200 rounded-full">
                        {{ $post->category->name }}
                    </span>
                </div>

                {{-- Up React Section --}}
                <div class="mt-4 border-t">
                    <x-up-react-button :post="$post" :hasUpReact="$hasUpReact" />
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
