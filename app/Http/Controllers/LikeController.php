<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function like(Post $post){
        $hasLiked = auth()->user()->hasLiked($post);

        if ($hasLiked) {
            $post->likes()->where('user_id', auth()->id())->delete();
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }

        return response()->json([
            'count' => $post->likes()->count(),
        ]);
    }
}
