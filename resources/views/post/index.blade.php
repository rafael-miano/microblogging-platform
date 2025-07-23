<x-app-layout>
    <div class="py-4">
        <div class="max-w-[900px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <x-category-tabs>
                        No Category Found
                    </x-category-tabs>
                </div>
            </div>
            <div class="mt-8 text-gray-900">
                @if (auth()->check() && auth()->user()->following()->count() === 0)
                    <div class="bg-blue-100 text-blue-700 text-sm px-4 py-2 rounded mb-4">
                        You're not following anyone yet — here are some recent posts from the community!
                    </div>
                @endif

                @forelse ($posts as $post)
                    <x-post-item :post="$post"></x-post-item>
                @empty
                    <div class="text-center text-gray py-16">No Posts Found.</div>
                @endforelse

            </div>
            {{ $posts->onEachSide(1)->links() }}
        </div>
    </div>
</x-app-layout>
