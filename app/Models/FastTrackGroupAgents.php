<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FastTrackGroupAgents extends Model
{
    protected $fillable = [
        'fast_track_group_agents_id',
        'customer_id',
    ];
    public function fastboatgroup(){
        return $this->hasMany(FastboatTrackGroup::class,'id'); 
    }
    public function customer(){
        return $this->belongsTo(Customer::class); 
    }
    public function tracksTrackAgent(){
        return $this->hasMany(FastboatTrackAgent::class); 
    }
}
