<x-app-layout>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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
                                    <button @click="follow()" x-text="following ? 'Unfollow' : 'Follow'"
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
                        <div class="flex gap-2 items-stretch">
                            <!-- Edit Button -->
                            <form action="{{ route('post.edit', $post->slug) }}" method="GET">
                                <x-primary-button
                                    class="inline-flex items-center h-full px-4 py-2 rounded-md bg-[#facc15] text-white text-xs font-semibold uppercase tracking-widest transition ease-in-out duration-150
            hover:bg-[#eab308] hover:text-white active:bg-[#ca9800] focus:outline-none focus:ring-2 focus:ring-[#facc15] focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-4 h-4 text-white mr-2" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L7.5 20.5H4v-3.5L16.732 3.732z" />
                                    </svg>
                                    Edit
                                </x-primary-button>
                            </form>

                            <!-- Delete Button -->
                            <form action="{{ route('post.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button
                                    class="inline-flex items-center h-full px-4 py-2 rounded-md bg-red-600 text-white text-xs font-semibold uppercase tracking-widest transition ease-in-out duration-150
            hover:bg-red-700 hover:text-white active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-4 h-4 text-white mr-2" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                    </svg>
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
