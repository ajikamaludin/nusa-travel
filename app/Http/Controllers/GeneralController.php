<?php

namespace App\Http\Controllers;

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
        $request->validate(['image' => 'required|image']);
        $file = $request->file('image');
        $file->store('uploads', 'public');

        return response()->json(['url' => asset($file->hashName('uploads'))]);
    }
}
