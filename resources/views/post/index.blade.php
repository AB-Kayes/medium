<x-app-layout>

    <div class="py-12">
        <div class="flex flex-col gap-4 max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-gray-900 dark:text-gray-100">
                    <x-category-tabs />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6">
                @forelse ($posts as $post)
                    <x-post-item :post="$post" />
                @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col-reverse md:flex-row">
                    <div class="flex-1 p-6 flex flex-col justify-center items-center"><h5 class="mb-3 text-xl font-bold tracking-tight text-gray-500 dark:text-gray-400">No posts found</h5>
                            </div>
                    </div>
                @endforelse
            </div>
            {{ $posts->onEachSide(1)->links() }}
        </div>
    </div>
</x-app-layout>