<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::query();

        if($request->has('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        return inertia('TourPackage/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create() 
    {
        return inertia('TourPackage/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'meta_tag' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'is_publish' => 'required|in:0,1',
            'images' => 'nullable|array',
            'images.*.file_id' => 'required|exists:files,id',
            'prices' => 'nullable|array',
            'prices.*.quantity' => 'required|numeric',
            'prices.*.price' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');

            File::create([
                'name' => $request->title,
                'path' => $file->hashName('uploads')
            ]);
        }

        $package = TourPackage::create([
            'slug' => Str::slug($request->title),
            'name' => $request->name,
            'title' => $request->title,
            'body' => $request->body,
            'meta_tag' => $request->meta_tag,
            'price' => $request->price,
            'cover_image' => $file->hashName('uploads'),
            'is_publish' => $request->is_publish,
        ]);

        // images
        collect($request->images)->map(function ($img) use($package) {
            $package->images()->create(['file_id' => $img['file_id']]);
        });

        // prices
        collect($request->prices)->map(function ($price) use($package) {
            $package->prices()->create([
                'quantity' => $price['quantity'],
                'price' => $price['price']
            ]);
        });

        return redirect()->route('packages.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']); 
    }

    public function edit(TourPackage $package) 
    {
        return inertia('TourPackage/Form', [
            'packages' => $package->load(['images', 'prices'])
        ]);
    }

    public function update(Request $request, TourPackage $package) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'meta_tag' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'is_publish' => 'required|in:0,1',
            'images' => 'nullable|array',
            'images.*.file_id' => 'required|exists:files,id',
            'prices' => 'nullable|array',
            'prices.*.quantity' => 'required|numeric',
            'prices.*.price' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');

            File::create([
                'name' => $request->title,
                'path' => $file->hashName('uploads')
            ]);

            $package->cover_image = $file->hashName('uploads');
        }

        $package->fill([
            'slug' => Str::slug($request->title),
            'name' => $request->name,
            'title' => $request->title,
            'body' => $request->body,
            'meta_tag' => $request->meta_tag,
            'price' => $request->price,
            'is_publish' => $request->is_publish,
        ]);

        $package->save();

        // images
        $package->images()->delete();
        collect($request->images)->map(function ($img) use($package) {
            $package->images()->create(['file_id' => $img['file_id']]);
        });

        // prices
        $package->prices()->delete();
        collect($request->prices)->map(function ($price) use($package) {
            $package->prices()->create([
                'quantity' => $price['quantity'],
                'price' => $price['price']
            ]);
        });

        return redirect()->route('packages.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']); 
    }

    public function destroy(TourPackage $package) 
    {
        $package->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']); 

    }
}
