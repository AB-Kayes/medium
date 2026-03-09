<a href="{{ route('post.show', ['username' => $post->user->username, 'post' => $post->slug]) }}" class="block group">
    <div
        class="bg-white dark:bg-gray-800 overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col-reverse md:flex-row">
        <div class="flex-1 p-6 flex flex-col justify-between">
            <div>
                <h5
                    class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white group-hover:text-brand dark:group-hover:text-blue-400 transition-colors duration-200">
                    {{ $post->title }}
                </h5>
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                    {{ Str::words($post->content, 20) }}
                </p>
            </div>
            <div class="flex-1">
                <div class="text-xs sm:text-sm text-gray-400 flex flex-wrap gap-1 sm:gap-2 items-center">
                    <span class="hidden sm:inline">by</span>
                    <a class="inline-flex gap-1 items-center text-gray-600 hover:underline"
                        href="{{ route('profile.show', $post->user->username) }}">
                        <img src="{{ $post->user->imageUrl() }}" alt="{{ $post->user->name }}"
                            class="w-4 h-4 sm:w-5 sm:h-5 rounded-full object-cover">
                        <span class="truncate max-w-[100px] sm:max-w-none">{{ $post->user->name }}</span>
                    </a>
                    <span class="hidden sm:inline">at</span>
                    <span
                        class="whitespace-nowrap">{{ $post->published_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}</span>
                    <div class="inline-flex gap-0.5 sm:gap-1 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                        </svg>
                        {{ $post->likes_count }}
                    </div>
                </div>
            </div>
        </div>
        @if($post->imageUrl('preview'))
            <div class="shrink-0 w-full md:w-64 h-48 md:h-auto md:self-stretch group overflow-hidden">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    src="{{ $post->imageUrl('preview') }}" alt="{{ $post->title }}" />
            </div>
        @endif
    </div>
</a>