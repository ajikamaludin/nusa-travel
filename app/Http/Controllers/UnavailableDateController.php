<?php

namespace App\Http\Controllers;

use App\Models\UnavailableDate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Response;

class UnavailableDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $query = UnavailableDate::query();

        return inertia('UnavailableDate/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        $request->validate([
            'close_date' => 'required|date',
        ]);

        UnavailableDate::create(['close_date' => Carbon::parse($request->close_date)]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnavailableDate $date): void
    {
        $request->validate([
            'close_date' => 'required|date',
        ]);

        $date->update(['close_date' => Carbon::parse($request->close_date)]);

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnavailableDate $date): void
    {
        $date->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
