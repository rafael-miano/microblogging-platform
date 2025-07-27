<x-app-layout>
    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-lg mb-4">
                Update Post: <strong class="font-bold">{{ $post->title }}</strong>
            </h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')

                    @if ($post->imageUrl())
                        <div class="mb-8">
                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full">
                        </div>
                    @endif

                    <!-- Image -->
                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image')" autofocus />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <!-- Title -->
                    <div class="mt-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $post->title)" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <!-- Content -->
                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-text-area-input id="content" class="block mt-1 w-full" type="text" name="content"
                            autofocus>{{ old('content', $post->content) }}</x-text-area-input>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Published_At -->
                    <div class="mt-4">
                        <x-input-label for="published_at" :value="__('Published At')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local"
                            name="published_at" :value="old('published_at', optional($post->published_at)->format('Y-m-d\TH:i'))" autofocus />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button
                            class="flex items-center gap-3 px-6 py-3 rounded-lg bg-[#488aec] text-white text-xs font-bold uppercase shadow-md transition-all duration-300 
        hover:bg-[#3574d4] hover:shadow-lg hover:text-white
        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#488aec] active:opacity-85">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-5 h-5 text-white" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l16 8-16 8V4z" />
                            </svg>
                            UPDATE POST
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
