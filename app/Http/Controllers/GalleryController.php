<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = File::query();

        if($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('Gallery/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'show_on' => 'required|numeric',
            'image' => 'required|image'
        ]);

        $file = $request->file('image');
        $file->store('uploads', 'public');

        if($request->show_on != 0) {
            $showOn = File::where('show_on', $request->show_on);
            if($showOn->count() >= 1) {
                $showOn->update(['show_on' => 0]);
            }
        }

        File::create([
            'name' => $request->name,
            'show_on' => $request->show_on,
            'path' => $file->hashName('uploads'),
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']); 
    }

    public function update(Request $request, File $file)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'show_on' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        if($request->show_on != 0) {
            $showOn = File::where('show_on', $request->show_on);
            if($showOn->count() >= 1) {
                $main = $showOn->update(['show_on' => 0]);
            }
        }

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('uploads', 'public');
            $file->path = $image->hashName('uploads');
        }

        $file->name = $request->name;
        $file->show_on = $request->show_on;
        $file->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed updated']); 
    }

    public function destroy(File $file)
    {
        $file->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']); 
    }
}
