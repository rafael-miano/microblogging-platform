<div class="relative border-b border-gray-200 overflow-hidden">
    <ul class="flex overflow-x-auto hide-scrollbar scroll-smooth px-4 space-x-6">
        <!-- For You Tab -->
        <li class="shrink-0">
            <a href="/"
               class="{{ request('category')
                    ? 'inline-block pb-2 pt-3 text-[13px] font-normal text-gray-500 hover:text-black transition-colors'
                    : 'inline-block pb-2 pt-3 text-[13px] font-normal text-black border-b border-black' }}">
                For You
            </a>
        </li>

        <!-- Category Tabs -->
        @foreach ($categories as $category)
            <li class="shrink-0">
                <a href="{{ route('post.byCategory', $category) }}"
                   class="{{ Route::currentRouteNamed('post.byCategory') && request('category')->id == $category->id
                        ? 'inline-block pb-2 pt-3 text-[13px] font-normal text-black border-b border-black'
                        : 'inline-block pb-2 pt-3 text-[13px] font-normal text-gray-500 hover:text-black transition-colors' }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
