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
                    <div class="flex justify-between gap-2">
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
                                    @if($post->user && $post->user->id !== auth()->id() && auth()->check())
                                        <button @click="toggleFollow()" class="text-sm"
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
                        @if($post->user_id === auth()->id())
                        <div>
                            <a href="{{ route('post.edit', $post->slug) }}">
                                <x-primary-button class="text-sm">
                                    Edit Post
                                </x-primary-button>
                            </a>
                            <form action="{{ route('post.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                            <x-danger-button type="submit" class="text-sm">
                                Delete Post
                            </x-danger-button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @if($post->user_id === auth()->id())
                    <x-like-button :post="$post" />
                    @endif
                    {{-- Post Content --}}
                    <div class="flex flex-col gap-4">
                        @if($post->imageUrl('large'))
                            <img src="{{ $post->imageUrl('large') }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover rounded-lg">
                        @endif
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