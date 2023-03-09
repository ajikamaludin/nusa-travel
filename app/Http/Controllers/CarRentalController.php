<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    public function index(Request $request)
    {
        $query = CarRental::query();

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return inertia('CarRental/Index', [
            'query' => $query->orderBy('created_at', 'asc')->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'capacity' => 'required|numeric',
            'luggage' => 'required|numeric',
            'car_owned' => 'required|numeric',
            'transmission' => 'required|string',
            'image' => 'required|image',
            'is_publish' => 'required|in:0,1',
        ]);

        $file = $request->file('image');
        $file->store('uploads', 'public');

        CarRental::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'luggage' => $request->luggage,
            'car_owned' => $request->car_owned,
            'transmission' => $request->transmission,
            'cover_image' => $file->hashName('uploads'),
            'is_publish' => $request->is_publish,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function update(Request $request, CarRental $car)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'capacity' => 'required|numeric',
            'luggage' => 'required|numeric',
            'car_owned' => 'required|numeric',
            'transmission' => 'required|string',
            'image' => 'nullable|image',
            'is_publish' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->store('uploads', 'public');
            $car->cover_image = $file->hashName('uploads');
        }

        $car->fill([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'luggage' => $request->luggage,
            'car_owned' => $request->car_owned,
            'transmission' => $request->transmission,
            'is_publish' => $request->is_publish,
        ]);

        $car->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(CarRental $car)
    {
        $car->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
