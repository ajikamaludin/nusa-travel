<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class FastboatTrackGroup extends Model
{
    protected $cascadeDeletes = ['tracks'];

    protected $fillable = [
        'fastboat_id',
        'name',
        'data_source',
    ];

    public function fastboat()
    {
        return $this->belongsTo(Fastboat::class);
    }

    public function tracks()
    {
        return $this->hasMany(FastboatTrack::class);
    }

    public function places()
    {
        return $this->hasMany(FastboatTrackOrder::class);
    }

    public function tracksAgent()
    {
        return $this->hasMany(FastboatTrack::class)
        ->leftJoin('fastboat_track_agents', 'fastboat_track_id', '=', 'fastboat_tracks.id')
        ->select('fastboat_tracks.id as id', 'fastboat_source_id', 'fastboat_destination_id', 'fastboat_tracks.fastboat_track_group_id', 'arrival_time', 'departure_time', 'customer_id', DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'))
        ->orderBy('fastboat_tracks.created_at', 'desc');
    }

    public function tracksAgents()
    {
        return $this->hasMany(FastboatTrack::class)
        ->join('fastboat_track_agents', 'fastboat_track_id', '=', 'fastboat_tracks.id')
        ->select('fastboat_tracks.id as id', 'fastboat_source_id', 'fastboat_destination_id', 'fastboat_tracks.fastboat_track_group_id', 'arrival_time', 'departure_time', DB::raw('sum(fastboat_track_agents.price) as price'))
        ->orderBy('fastboat_tracks.created_at', 'desc')
        ->groupBy('fastboat_tracks.fastboat_track_group_id', 'customer_id', 'fastboat_tracks.id');
    }

    public function tracksAgentsgroup()
    {
        return $this->hasMany(FastboatTrackGroupAgent::class);
    }
}
