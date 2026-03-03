<x-app-layout>
    <div class="mx-auto p-4 max-w-4xl">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex flex-col gap-2">
                    {{-- Title --}}
                    <h1 class="text-3xl text-gray-900 dark:text-white mb-2">
                        {{ $post->title }}
                    </h1>
                    {{-- Author Info --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('profile.show', $post->user) }}">
                            <img src="{{ $post->user->imageUrl() }}" alt="{{ $post->user->name }}"
                                class="w-12 h-12 rounded-full ">
                        </a>
                        <div class="flex flex-col">
                            <x-follow-container :user="$post->user" class="flex items-center gap-2">
                                <a href="{{ route('profile.show', $post->user) }}"
                                    class="text-lg font-bold text-gray-900 dark:text-white hover:underline">
                                    {{ $post->user->name }}
                                </a>
                                @if($post->user && $post->user->id !== auth()->id())
                                <button
                                    @click="toggleFollow()"
                                    class="text-sm"
                                    x-text="following ? 'Unfollow' : 'Follow'"
                                    :class="following ? 'text-red-600 dark:text-red-400' : 'text-green-500 dark:text-green-400'">
                                </button>
                                @endif
                            </x-follow-container>
                            <div class="flex gap-1">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $post->readTime() }}
                                </div>
                                <span class="text-gray-500 dark:text-gray-400">•</span>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $post->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-like-button :post="$post" />
                    {{-- Post Content --}}
                    <div class="flex flex-col gap-4">
                        <img src="{{ $post->image}}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover rounded-lg">
                        <div class="flex flex-col gap-2 text-gray-600 dark:text-gray-400">
                            {{ $post->content }}
                        </div>
                    </div>

                    <div
                        class="w-fit text-sm bg-gray-200 dark:bg-gray-700 rounded-full px-4 py-2 text-gray-600 dark:text-gray-400">
                        {{ $post->category->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>