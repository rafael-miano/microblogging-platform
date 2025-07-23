<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1 pr-8">
                        <h1 class="text-5xl font-bold">{{ $user->name }}</h1>
                        <div class="mt-8">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post"></x-post-item>
                            @empty
                                <div class="text-center text-gray py-16">No Posts Found.</div>
                            @endforelse
                        </div>
                    </div>
                    {{-- User Details Start Section --}}
                    <x-follow-ctr :user="$user">
                        <div class="flex flex-col items-start space-y-4">
                            <x-user-avatar :user="$user" size="h-20 w-20" />

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    <span x-text="followersCount"></span> followers
                                </p>
                            </div>

                            @if($user->bio)
                                <p class="text-sm text-gray-700">{{ $user->bio }}</p>
                            @endif

                            @if(auth()->user() && auth()->user()->id !== $user->id)
                                <button @click="follow()" x-text="following ? 'Unfollow' : 'Follow'"
                                    class="mt-2 text-sm font-medium rounded-full px-4 py-1.5"
                                    :class="following ? 'bg-gray-200 text-green-700 hover:bg-gray-300' : 'bg-green-600 text-white hover:bg-green-700'">
                                </button>

                            @endif
                        </div>
                    </x-follow-ctr>
                </div>
                {{-- User Details End Section --}}
            </div>
        </div>
    </div>
    </div>
</x-app-layout>