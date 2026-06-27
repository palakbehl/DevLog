<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {

    $posts = Post::latest()->get();

    return view(
        'posts.index',
        compact('posts')
    );
    }

    public function create()
    {
        return view('posts.create');

    }

    public function store(Request $request)
    {
        $request->validate([

'title'=>'required|max:255',

'content'=>'required',

'featured_image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'

]);
$imagePath = null; // default value if user does not upload an image

if($request->hasFile('featured_image')) // checks if the user has uploaded a file for the featured_image field. If they have, it will proceed to store the image and save the path in the database. If not, it will leave the $imagePath as null.
{
    $imagePath = $request 
                    ->file('featured_image') // return the uploaded file object for the featured_image field. This object provides methods to interact with the uploaded file, such as moving it to a storage location or getting its original name.
                    ->store('posts','public'); // stores the uploaded image in the 'posts' directory within the 'public' disk. The 'public' disk is typically configured to point to the 'storage/app/public' directory, which is publicly accessible via a symbolic link in the 'public' directory of your Laravel application. The store() method will automatically generate a unique filename for the uploaded image to avoid overwriting existing files with the same name. The path to the stored image will be returned and saved in the $imagePath variable.
}

    Post::create([

        'user_id'=>auth()->id(),

        'title'=>$request->title,

        'slug'=>Str::slug($request->title), // Str::slug() is a Laravel helper function that converts a string into a URL-friendly "slug". For example, if the title is "My First Post", Str::slug($request->title) would return "my-first-post". This is useful for creating readable and SEO-friendly URLs.

        'content'=>$request->content,
        'featured_image'=>$imagePath,

    ]);

    return redirect() // redirects the user to the posts.index route after successfully creating a new post. This is a common practice in web applications to provide feedback to the user and navigate them to a relevant page after an action is completed.

        ->route('posts.index')

        ->with('success','Post Created');

    }

    public function show(Post $post) // Post $post is a route model binding, which means that Laravel will automatically fetch the Post model instance that corresponds to the {post} parameter in the route. This allows you to work with the Post model directly in your controller method without having to manually retrieve it from the database.
    {

    }

    

    public function edit(Post $post)
    {
        if (auth()->user()->isAdmin()) {

        $posts = Post::latest()->get();

    } else {

        $posts = Post::where('user_id', auth()->id())
                     ->latest()
                     ->get();

    }

    return view('posts.index', compact('posts'));
    }

    public function update(Request $request, Post $post)
    {
        if(
    auth()->user()->isAuthor()
    &&
    auth()->id() != $post->user_id
){
    abort(403);
}
        $request->validate([

        'title'=>'required|max:255',

        'content'=>'required'

    ]);

    $post->update([

        'title'=>$request->title,

        'slug'=>Str::slug($request->title),

        'content'=>$request->content,

        'is_published'=>$request->has('is_published')

    ]);

    return redirect()

    ->route('posts.index')

    ->with('success','Post Updated');

    }

    public function destroy(Post $post)
    {
        if(
    auth()->user()->isAuthor()
    &&
    auth()->id() != $post->user_id
){
    abort(403);
}
         $post->delete();

    return redirect()

    ->route('posts.index')

    ->with('success','Post Deleted');

    }
}