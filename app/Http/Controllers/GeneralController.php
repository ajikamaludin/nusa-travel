<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Response;

class GeneralController extends Controller
{
    public function index(): Response
    {
        return inertia('Dashboard');
    }

    public function indev(): Response
    {
        return inertia('Dev');
    }

    public function upload(Request $request)
    {
        $request->validate(['image' => 'required|file']);
        $file = $request->file('image');
        $file->store('uploads', 'public');

        $uploaded = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $file->hashName('uploads'),
        ]);

        return response()->json([
            'id' => $uploaded->id,
            'name' => $uploaded->name,
            'url' => asset($file->hashName('uploads')),
        ]);
    }
}
