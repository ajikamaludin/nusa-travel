<?php

namespace App\Models;

use App\Models\Traits\OrderAble;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class FastboatTrack extends Model
{
    use OrderAble;

    protected $ORDER_NAMES = ['source.name', 'destination.name'];

    protected $fillable = [
        'fastboat_track_group_id',
        'fastboat_source_id',
        'fastboat_destination_id',
        'price',
        'arrival_time',
        'departure_time',
        'is_publish',
    ];

    public function group()
    {
        return $this->belongsTo(FastboatTrackGroup::class, 'fastboat_track_group_id');
    }

    public function source()
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_source_id')->withTrashed();
    }

    public function destination()
    {
        return $this->belongsTo(FastboatPlace::class, 'fastboat_destination_id')->withTrashed();
    }

    public function item()
    {
        return $this->hasMany(OrderItem::class, 'entity_id');
    }

    public function item_ordered()
    {
        return $this->hasMany(OrderItem::class, 'entity_id');
    }

    protected function arrivalTime(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => substr($value, 0, 5),
        );
    }

    protected function departureTime(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => substr($value, 0, 5),
        );
    }

    public function detail($date, $dropoff = null)
    {
        $detail = "<p>$this->order_detail (Fastboat)</p>
        <p>$this->arrival_time - $this->departure_time</p>
        <p>".Carbon::parse($date)->format('d-m-Y').'</p>';

        if($dropoff != null) {
            $detail .= "<p>Dropoff: $dropoff</p>";
        }

        $detail .= '<p>@ '.number_format($this->price, '0', ',', ' .').'</p>';

        return $detail;
    }

    public function getCapacity($date)
    {
        $cap = FastboatTrackOrderCapacity::where([
            'fastboat_track_group_id' => $this->group->id,
            'fastboat_source_id' => $this->fastboat_source_id,
            'fastboat_destination_id' => $this->fastboat_destination_id,
            'date' => $date,
        ])->first();

        if($cap != null) {
            return $cap->capacity;
        }

        return $this->group->fastboat->capacity;
    }

    public static function updateTrackUsage(FastboatTrack $track, $date, $quantity)
    {
        $tracks = $track->group->tracks;
        $fastboat = $track->group->fastboat;
        $places = $track->group->places;

        $capacities = [];
        // copy all tracks to capacities
        foreach($tracks as $t) {
            $capacity = FastboatTrackOrderCapacity::firstOrCreate([
                'fastboat_track_group_id' => $track->group->id,
                'fastboat_source_id' => $t->fastboat_source_id,
                'fastboat_destination_id' => $t->fastboat_destination_id,
                'date' => $date,
            ], [
                'capacity' => $fastboat->capacity,
            ]);
            dump($capacity);

            $rou = $t->fastboat_source_id.'|'.$t->fastboat_destination_id;
            $capacities[$rou] = $capacity;
        }

        // other track that impact
        $n = $places->count();
        $places = $places->toArray();
        $startIndex = null;
        $endIndex = null;
        foreach($places as $k => $place) {
            $isStart = $track->fastboat_source_id == $places[$k]['fastboat_place_id'];
            if($startIndex == null && $isStart) {
                $startIndex = $k;
            }
            $isEnd = $track->fastboat_destination_id == $places[$k]['fastboat_place_id'];
            if($endIndex == null && $isEnd) {
                $endIndex = $k;
            }
        }

        for ($i = 0; $i < $n; $i++) { // 1 2 3 4
            $isStart = $track->fastboat_source_id == $places[$i]['fastboat_place_id'];
            for ($j = $i + 1; $j < $n; $j++) { // 2 3 4
                $isEnd = $track->fastboat_destination_id == $places[$j]['fastboat_place_id'];
                $from = $places[$i]['fastboat_place_id'];
                $to = $places[$j]['fastboat_place_id'];
                $rou = $from.'|'.$to;
                if($isStart || $isEnd) {
                    $capacities[$rou]->update(['capacity' => $capacities[$rou]->capacity - $quantity]);
                }
                // diantara 2 titik adalah lebih besar dari titik awal dan lebih kecil dari titik akhir
                if ($startIndex < $i && $endIndex > $j) {
                    $capacities[$rou]->update(['capacity' => $capacities[$rou]->capacity - $quantity]);
                }
                // lainnya
                if($startIndex > $i && $endIndex < $j) {
                    $capacities[$rou]->update(['capacity' => $capacities[$rou]->capacity - $quantity]);
                }
            }
        }
    }
}
