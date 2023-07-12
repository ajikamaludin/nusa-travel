<?php

namespace App\Http\Controllers;

use App\Models\FastboatTrack;
use App\Models\UnavailableDate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function index(Request $request)
    {
        $dates = [];
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        if ($request->startDate != '' && $request->endDate != '') {
            $startDate = Carbon::parse($request->startDate);
            $endDate = Carbon::parse($request->endDate);
        }

        $date = Carbon::parse($startDate);
        while ($date <= $endDate) {
            $dates[] = [
                'today' => $date->isToday() ? 'Today' : '',
                'date' => $date->format('d'),
                'month' => $date->format('F'),
                '_d' => $date->format('d-m-Y'),
            ];

            $date = $date->addDay();
        }

        $trackWithAvabilities = [];
        $tracks = FastboatTrack::orderBy('updated_at', 'desc')->paginate(10);

        foreach ($tracks as $track) {
            $avalaible = [];

            foreach ($dates as $d) {
                $block = UnavailableDate::whereDate('close_date', Carbon::parse($d['_d']))
                    ->where('fastboat_track_id', null)
                    ->first();
                if ($block != null) {
                    $avalaible[] = ['text' => 'Tutup', 'id' => $block->id];
                } else {
                    $block = UnavailableDate::whereDate('close_date', Carbon::parse($d['_d']))
                        ->where('fastboat_track_id', $track->id)
                        ->first();
                    if ($block != null) {
                        $avalaible[] = ['text' => 'Tutup', 'id' => $block->id];
                    } else {
                        $avalaible[] = ['text' => $track->getCapacity($d['_d']), 'id' => null];
                    }
                }
            }

            $trackWithAvabilities[] = [
                'track' => $track,
                'avalaible' => $avalaible,
            ];
        }

        return inertia('Calender/Index', [
            'dates' => $dates,
            'tracks' => $trackWithAvabilities,
            'track_paginate' => $tracks,
            '_startDate' => $startDate,
            '_endDate' => $endDate,
        ]);
    }

    public function create()
    {
        return inertia('Calender/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'close_date' => 'required|date',
            'fastboat_track_id' => 'nullable|exists:fastboat_tracks,id'
        ]);

        UnavailableDate::create([
            'close_date' => Carbon::parse($request->close_date),
            'fastboat_track_id' => $request->fastboat_track_id,
        ]);

        return redirect()->route('calender.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function edit(UnavailableDate $date)
    {
        return inertia('Calender/Form', [
            'date' => $date
        ]);
    }

    public function update(Request $request, UnavailableDate $date)
    {
        $request->validate([
            'close_date' => 'required|date',
            'fastboat_track_id' => 'nullable|exists:fastboat_tracks,id'
        ]);

        $date->update([
            'close_date' => Carbon::parse($request->close_date),
            'fastboat_track_id' => $request->fastboat_track_id,
        ]);

        return redirect()->route('calender.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function destroy(UnavailableDate $date)
    {
        $date->delete();

        return redirect()->route('calender.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
