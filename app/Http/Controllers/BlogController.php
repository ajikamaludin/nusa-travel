<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;

class BlogController extends Controller
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

    public function upload(Request $request) 
    {
        $request->validate(['image' => 'required|image']);
        $file = $request->file('image');
        $file->store('uploads', 'public');

        return response()->json(['url' => asset($file->hashName('uploads'))]);
    }

    public function destroy(Post $post) 
    {
        $post->delete();
    }
}
