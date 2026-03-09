<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \DB::listen(function ($query) {
           \Log::info($query->sql);
        });

        $posts = Post::where('published_at', '<=', now())->with(['user', 'media'])->withCount('likes')->orderBy('created_at', 'DESC')->paginate(5);

        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('post.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);

        $post->addMediaFromRequest('image')->toMediaCollection();

        return redirect()->route('post.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        return view('post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);
        $categories = Category::all();
        return view('post.edit', ['post' => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);

        $validated = $request->validated();

        $post->update($validated);

        if ($request->hasFile('image')) {
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route('post.myPosts')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);
        $post->delete();
        return redirect()->route('post.myPosts')->with('success','Post deleted successfully');
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->where('published_at', '<=', now())->with(['user', 'media'])->withCount('likes')->orderBy('created_at', 'DESC')->paginate(5);

        return view('post.index', ['posts' => $posts]);
    }

    public function myPosts()
    {
        $user = auth()->user();
        $posts = $user->posts()->with(['user', 'media'])->withCount('likes')->orderBy('created_at', 'DESC')->paginate(5);

        return view('post.index', ['posts' => $posts]);
    }
}
