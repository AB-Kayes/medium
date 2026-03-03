<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
        $user->followers()->toggle(auth()->user());

        return response()->json([
            'followers' => $user->followers()->count(),
        ]);
    }
}
