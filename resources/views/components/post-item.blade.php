<div
    class="bg-white dark:bg-gray-800 overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col-reverse md:flex-row">
    <div class="flex-1 p-6 flex flex-col justify-between">
        <div>
            <a href="#" class="block group">
                <h5
                    class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white group-hover:text-brand dark:group-hover:text-blue-400 transition-colors duration-200">
                    {{ $post->title }}
                </h5>
            </a>
            <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                {{ Str::words($post->content, 20) }}
            </p>
        </div>
        <a href="#"
            class="group inline-flex items-center gap-2 bg-brand text-white hover:bg-blue-600 dark:hover:bg-blue-500 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 shadow-sm hover:shadow-md font-medium leading-5 rounded-lg text-sm px-5 py-2.5 focus:outline-none transition-all duration-200 ease-in-out transform hover:scale-[1.02] active:scale-[0.98] w-fit">
            <span>Read more</span>
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
        </a>
    </div>
    <a href="#" class="shrink-0 w-full md:w-64 h-48 md:h-auto md:self-stretch group overflow-hidden">
        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="{{ $post->title }}" />
    </a>
</div>