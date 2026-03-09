<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-medium mb-6">{{ __('Edit Post') }}</h2>

                    <form action="{{ route('post.update', $post) }}" method="post" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')
                        {{-- image --}}
                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <x-image-uploader name="image" size="large" :existingImage="$post->imageUrl('large')"/>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>
                        {{-- title --}}
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title', $post->title)" autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        {{-- category --}}
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <x-select-input id="category_id" name="category_id" class="mt-1 block w-full">
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                        {{-- content --}}
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <x-text-area-input id="content" name="content" class="mt-1 block w-full"
                                rows="10">{{ old('content', $post->content) }}</x-text-area-input>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                        {{-- Published at --}}
                        <div>
                            <x-input-label for="published_at" :value="__('Published At')" />
                            <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full"
                                :value="old('published_at', $post->published_at)" />
                            <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
                        </div>
                        {{-- submit button --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Post') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>