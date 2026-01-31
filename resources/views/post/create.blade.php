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
                            <div class="flex items-center justify-center w-full mt-1">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                    <div id="dropzone-content"
                                        class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                            800x400px)</p>
                                    </div>
                                    <div id="image-preview"
                                        class="hidden w-full h-full items-center justify-center relative group">
                                        <img id="preview-img" src="" alt="Preview"
                                            class="max-w-full max-h-full object-contain rounded-lg">
                                        <div id="preview-actions"
                                            class="absolute inset-0 flex items-center justify-center gap-2 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg pointer-events-none">
                                            <button type="button" id="reupload-btn"
                                                class="opacity-0 group-hover:opacity-100 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-all pointer-events-auto">
                                                {{ __('Change Image') }}
                                            </button>
                                            <button type="button" id="remove-btn"
                                                class="opacity-0 group-hover:opacity-100 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all pointer-events-auto">
                                                {{ __('Remove') }}
                                            </button>
                                        </div>
                                    </div>
                                    <input id="dropzone-file" name="image" type="file" class="hidden"
                                        accept="image/*" />
                                </label>
                            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropzoneFile = document.getElementById('dropzone-file');
            const dropzoneContent = document.getElementById('dropzone-content');
            const imagePreview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const reuploadBtn = document.getElementById('reupload-btn');
            const removeBtn = document.getElementById('remove-btn');
            const dropzoneLabel = dropzoneFile.closest('label');

            // Function to show preview
            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    dropzoneContent.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                    imagePreview.classList.add('flex');
                };
                reader.readAsDataURL(file);
            }

            // Function to reset to initial state
            function resetUploader() {
                dropzoneFile.value = '';
                previewImg.src = '';
                dropzoneContent.classList.remove('hidden');
                imagePreview.classList.add('hidden');
                imagePreview.classList.remove('flex');
            }

            // Handle file selection
            dropzoneFile.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    showPreview(file);
                }
            });

            // Handle reupload button
            reuploadBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                dropzoneFile.click();
            });

            // Handle remove button
            removeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                resetUploader();
            });

            // Allow clicking on preview area to reupload (buttons use stopPropagation)
            imagePreview.addEventListener('click', function (e) {
                dropzoneFile.click();
            });

            // Handle drag and drop
            dropzoneLabel.addEventListener('dragover', function (e) {
                e.preventDefault();
                dropzoneLabel.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
            });

            dropzoneLabel.addEventListener('dragleave', function (e) {
                e.preventDefault();
                dropzoneLabel.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
            });

            dropzoneLabel.addEventListener('drop', function (e) {
                e.preventDefault();
                dropzoneLabel.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');

                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    dropzoneFile.files = e.dataTransfer.files;
                    const event = new Event('change', { bubbles: true });
                    dropzoneFile.dispatchEvent(event);
                }
            });
        });
    </script>
</x-app-layout>