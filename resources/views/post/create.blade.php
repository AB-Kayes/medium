<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-medium mb-6">{{ __('Create Post') }}</h2>

                    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        {{-- image --}}
                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <x-image-uploader name="image" size="large" />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>
                        {{-- title --}}
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title')" autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        {{-- category --}}
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <x-select-input id="category_id" name="category_id" class="mt-1 block w-full">
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                        {{-- content --}}
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <x-text-Area-input id="content" name="content" class="mt-1 block w-full"
                                rows="10">{{ old('content') }}</x-text-Area-input>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                        {{-- submit button --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Post') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>