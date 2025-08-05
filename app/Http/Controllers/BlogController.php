<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $featuredPost = Blog::published()->latest('published_at')->first();
        $posts = Blog::published()->latest('published_at')->skip(1)->take(6)->get();
        
        return view('blog', compact('featuredPost', 'posts'));
    }

    public function show($slug)
    {
        $post = Blog::where('slug', $slug)->firstOrFail();
        
        // Get related posts
        $relatedPosts = Blog::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();
        
        return view('post', compact('post', 'relatedPosts'));
    }
}
