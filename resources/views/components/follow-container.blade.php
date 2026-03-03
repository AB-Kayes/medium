@props(['user'])

<div {{ $attributes }} x-data="{
    following: {{ auth()->check() && $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
    followersCount: {{ $user->followers()->count() }},
    async toggleFollow() {
        this.following = !this.following;
        try {
            const response = await axios.post('{{ route('follower.follow', $user) }}');
            this.followersCount = response.data.followers;
        } catch (error) {
            console.error(error);
        }
    },
}">
    {{ $slot }}
</div>