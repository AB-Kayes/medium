<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold">{{ $user->name }}</h1>
                        <div class="flex flex-col gap-2 mt-4 mr-4">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post" />
                            @empty
                                <div
                                    class="bg-white dark:bg-gray-800 overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col-reverse md:flex-row">
                                    <div class="flex-1 p-6 flex flex-col justify-center items-center">
                                        <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-500 dark:text-gray-400">
                                            No posts found</h5>
                                    </div>
                                </div>
                            @endforelse
                            {{ $posts->onEachSide(1)->links() }}
                        </div>
                    </div>
                    <x-follow-container :user="$user"  class="w-[20vw] flex flex-col items-center border-l px-4">
                        <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full ">
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span
                                x-text="followersCount + ' ' + (followersCount === 1 ? 'follower' : 'followers')">
                            </span>
                        </p>
                        <p class="text-gray-700 dark:text-gray-400">{{ $user->bio }}</p>
                        @if(auth()->user() && auth()->user()->id !== $user->id)
                            <div class="mt-2">
                                <button @click="toggleFollow()" class="text-white px-2 py-1 rounded-full"
                                    x-text="following ? 'Unfollow' : 'Follow'"
                                    :class="following ? 'bg-red-600' : 'bg-green-500'">
                                </button>
                            </div>
                        @endif
                    </x-follow-container>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>