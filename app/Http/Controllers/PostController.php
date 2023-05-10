<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Services\AsyncService;
use App\Services\DeeplService;
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
        $query = Post::query()->whereNull(['lang']);

        if ($request->has('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        return inertia('Blog/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('Blog/Form', [
            'tags' => Tag::orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable',
            'image' => 'required|image',
            'is_publish' => 'required|in:0,1',
            'tags' => 'nullable|array',
            'tags.*.id' => 'required|exists:tags,id',
            'meta_tag' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');

            File::create([
                'name' => $request->title,
                'path' => $file->hashName('uploads'),
            ]);
        }

        $post = Post::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
            'is_publish' => $request->is_publish,
            'meta_tag' => $request->meta_tag,
            'cover_image' => $file->hashName('uploads'),
        ]);

        foreach (collect($request->tags) as $tag) {
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag['id'],
            ]);
        }

        AsyncService::async(function () use ($post) {
            DeeplService::translatePost($post);
        });

        return redirect()->route('post.index')
            ->with('message', ['type' => 'success', 'message' => 'Post has beed saved']);
    }

    public function edit(Post $post)
    {
        return inertia('Blog/Form', [
            'tags' => Tag::orderBy('created_at', 'desc')->get(),
            'post' => $post->load(['tags']),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable',
            'image' => 'nullable|image',
            'is_publish' => 'required|in:0,1',
            'tags' => 'nullable|array',
            'tags.*.id' => 'required|exists:tags,id',
            'meta_tag' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');
            $post->cover_image = $file->hashName('uploads');

            File::create([
                'name' => $request->title,
                'path' => $file->hashName('uploads'),
            ]);
        }

        $post->fill([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'body' => $request->body,
            'is_publish' => $request->is_publish,
            'meta_tag' => $request->meta_tag,
        ]);

        $post->save();

        PostTag::where('post_id', $post->id)->delete();
        foreach ($request->tags as $tag) {
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag['id'],
            ]);
        }

        AsyncService::async(function () use ($post) {
            DeeplService::translatePost($post);
        });

        return redirect()->route('post.index')
            ->with('message', ['type' => 'success', 'message' => 'Post has beed updated']);
    }

    public function destroy(Post $post)
    {
        $post->delete();
    }
}
