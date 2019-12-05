<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return view('posts.show')->with('post', $post);
    }

    public function index(Post $post)
    {
        //$posts = Post::get();
        $posts = Post::published()->get();

        return view('posts.index')->with('posts', $posts);
    }
    public function store(Request $request)
{
    $request->user()->posts()->create($request->only([
        'published_at',
        'title',
        'body',
    ]));
   
}
}
