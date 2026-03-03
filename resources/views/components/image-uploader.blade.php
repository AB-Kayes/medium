@props([
    'name' => 'image',
    'size' => 'large', // 'small' or 'large'
    'hint' => null,
    'existingImage' => null, // URL of existing image to display
])

@php
    $uniqueId = 'dropzone-' . uniqid();
    $dropzoneFileId = $uniqueId . '-file';
    $dropzoneContentId = $uniqueId . '-content';
    $imagePreviewId = $uniqueId . '-preview';
    $previewImgId = $uniqueId . '-preview-img';
    $reuploadBtnId = $uniqueId . '-reupload-btn';
    $removeBtnId = $uniqueId . '-remove-btn';
    
    $heightClass = $size === 'small' ? 'h-32' : 'h-64';
    $iconSize = $size === 'small' ? 'w-6 h-6' : 'w-8 h-8';
    $iconMargin = $size === 'small' ? 'mb-2' : 'mb-4';
    $textSize = $size === 'small' ? 'text-xs' : 'text-sm';
    $buttonPadding = $size === 'small' ? 'px-3 py-1.5' : 'px-4 py-2';
    $buttonTextSize = $size === 'small' ? 'text-xs' : 'text-sm';
    $hintText = $hint ?? ($size === 'small' ? 'SVG, PNG, JPG or GIF' : 'SVG, PNG, JPG or GIF (MAX. 800x400px)');
@endphp

<div class="flex items-center justify-center w-full mt-1">
    <label for="{{ $dropzoneFileId }}"
        class="flex flex-col items-center justify-center w-full {{ $heightClass }} bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
        <div id="{{ $dropzoneContentId }}"
            class="{{ $existingImage ? 'hidden' : 'flex' }} flex-col items-center justify-center pt-5 pb-6">
            <svg class="{{ $iconSize }} {{ $iconMargin }} text-gray-500 dark:text-gray-400" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
            </svg>
            <p class="mb-1 {{ $textSize }} text-gray-500 dark:text-gray-400">
                <span class="font-semibold">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hintText }}</p>
        </div>
        <div id="{{ $imagePreviewId }}"
            class="{{ $existingImage ? 'flex' : 'hidden' }} w-full h-full items-center justify-center relative group">
            <img id="{{ $previewImgId }}" src="{{ $existingImage ?? '' }}" alt="Preview"
                class="max-w-full max-h-full object-contain rounded-lg">
            <div id="{{ $uniqueId }}-preview-actions"
                class="absolute inset-0 flex items-center justify-center gap-2 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg pointer-events-none">
                <button type="button" id="{{ $reuploadBtnId }}"
                    class="opacity-0 group-hover:opacity-100 {{ $buttonPadding }} bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg {{ $buttonTextSize }} font-medium transition-all pointer-events-auto">
                    {{ __('Change Image') }}
                </button>
                <button type="button" id="{{ $removeBtnId }}"
                    class="opacity-0 group-hover:opacity-100 {{ $buttonPadding }} bg-red-600 hover:bg-red-700 text-white rounded-lg {{ $buttonTextSize }} font-medium transition-all pointer-events-auto">
                    {{ __('Remove') }}
                </button>
            </div>
        </div>
        <input id="{{ $dropzoneFileId }}" name="{{ $name }}" type="file" class="hidden"
            accept="image/*" />
        <input type="hidden" id="{{ $uniqueId }}-remove-flag" name="{{ $name }}_remove" value="0" />
    </label>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropzoneFile = document.getElementById('{{ $dropzoneFileId }}');
        const dropzoneContent = document.getElementById('{{ $dropzoneContentId }}');
        const imagePreview = document.getElementById('{{ $imagePreviewId }}');
        const previewImg = document.getElementById('{{ $previewImgId }}');
        const reuploadBtn = document.getElementById('{{ $reuploadBtnId }}');
        const removeBtn = document.getElementById('{{ $removeBtnId }}');
        const removeFlag = document.getElementById('{{ $uniqueId }}-remove-flag');
        const dropzoneLabel = dropzoneFile.closest('label');
        const hasExistingImage = {{ $existingImage ? 'true' : 'false' }};

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
            // Set remove flag if there was an existing image
            if (hasExistingImage) {
                removeFlag.value = '1';
            }
        }

        // Ensure existing image is shown on page load (Blade already sets initial classes, but this ensures it)
        if (hasExistingImage) {
            dropzoneContent.classList.add('hidden');
            imagePreview.classList.remove('hidden');
            imagePreview.classList.add('flex');
        }

        // Handle file selection
        dropzoneFile.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                showPreview(file);
                // Clear remove flag when a new file is selected
                removeFlag.value = '0';
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
                // Clear remove flag when a new file is dropped
                removeFlag.value = '0';
                const event = new Event('change', { bubbles: true });
                dropzoneFile.dispatchEvent(event);
            }
        });
    });
</script>

