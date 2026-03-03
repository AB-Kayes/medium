<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $user->loadCount('followers');

        $posts = $user->posts()->latest()->paginate(5);

        return view('profile.show', ['user' => $user, 'posts' => $posts]);
    }
}
