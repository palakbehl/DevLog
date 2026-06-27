<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostApiController extends Controller
{
    public function index()
    {
        return Post::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $validated['user_id'] = 1; // Temporary
        $validated['slug'] = Str::slug($validated['title']);

        return Post::create($validated); // This line creates a new Post record in the database using the validated data. The 'create' method is a mass assignment method that takes an array of attributes and saves them to the database. The newly created Post instance is then returned as a response.
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $validated['slug'] = Str::slug($validated['title']); 

        $post->update($validated);

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post Deleted Successfully'
        ]);
    }
}