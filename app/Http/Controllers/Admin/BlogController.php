<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Blog::latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:blogs,slug',
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'category' => 'required|max:100',
            'author' => 'required|max:100',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'read_time' => 'required|integer|min:1|max:60',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads/blog', $filename, 'public');
            $data['featured_image'] = $filename;
        }

        // Set published_at if status is published
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Blog::findOrFail($id);
        return view('admin.blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:blogs,slug,' . $id,
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'category' => 'required|max:100',
            'author' => 'required|max:100',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'read_time' => 'required|integer|min:1|max:60',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete('uploads/blog/' . $post->featured_image);
            }
            
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('uploads/blog', $filename, 'public');
            $data['featured_image'] = $filename;
        }

        // Set published_at if status is published and not already set
        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Blog::findOrFail($id);
        
        // Delete featured image
        if ($post->featured_image) {
            Storage::disk('public')->delete('uploads/blog/' . $post->featured_image);
        }
        
        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully!');
    }
}
