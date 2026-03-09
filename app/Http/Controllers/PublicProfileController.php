<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $user->loadCount('followers');

        $posts = $user->posts()->where('published_at', '<=', now())->with(['user', 'media'])->withCount('likes')->latest()->paginate(5);

        return view('profile.show', ['user' => $user, 'posts' => $posts]);
    }
}
