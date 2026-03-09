<ul class="flex flex-wrap text-sm font-medium text-center justify-center text-body dark:text-gray-400">
    <li class="me-2">
        <a href="{{ route('post.index') }}" class="{{ request('category') ? 'inline-block px-4 py-3 rounded-base hover:text-heading dark:hover:text-gray-100 hover:bg-neutral-secondary-soft dark:hover:bg-gray-700' : 'inline-block px-4 py-2.5 text-white bg-brand rounded-base active' }}" aria-current="page">All</a>
    </li>
    @foreach ($categories as $category)
        <li class="me-2">
            <a href="{{ route('post.byCategory', $category) }}"
                class="{{ Route::currentRouteNamed('post.byCategory') && request('category')->id == $category->id ? 'inline-block px-4 py-2.5 text-white bg-brand rounded-base active' : 'inline-block px-4 py-3 rounded-base hover:text-heading dark:hover:text-gray-100 hover:bg-neutral-secondary-soft dark:hover:bg-gray-700' }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>