<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $query = Post::query();

        if($request->has('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        return inertia('Blog/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create() 
    {
        return inertia('Blog/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'image' => 'required|image'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');
        }

        Post::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
            'meta_tag' => 'tag1',
            'cover_image' => $file->hashName('uploads'),
        ]);

        return redirect()->route('post.index')
            ->with('message', ['type' => 'success', 'message' => 'Post has beed saved']); 
    }

    public function update(Request $request, Post $post) 
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'image' => 'required|image'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');
            $post->cover_image = $file->hashName('uploads');
        }

        $post->fill([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
            'meta_tag' => 'tag1',
        ]);

        $post->save();

        return redirect()->route('post.index')
            ->with('message', ['type' => 'success', 'message' => 'Post has beed updated']); 
    }

    public function destroy(Post $post) 
    {
        $post->delete();
    }
}
