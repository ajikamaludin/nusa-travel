<?php

namespace App\Models;

use App\Models\Traits\OrderAble;
use App\Services\EkajayaService;
use App\Services\GlobaltixService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FastboatTrack extends Model
{
    use OrderAble;

    protected $ORDER_NAMES = ['source.name', 'destination.name'];

    protected $fillable = [
        'id',
        'fastboat_track_group_id',
        'fastboat_source_id',
        'fastboat_destination_id',
        'price',
        'arrival_time', //kedatangan
        'departure_time', //keberangkatan
        'is_publish',
        'data_source',
        'deleted_at',
        'attribute_json',
    ];

    protected $appends = [
        'alternative_name',
        'time_text',
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

    public function trackAgent()
    {
        return $this->hasMany(FastboatTrackAgent::class);
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

    protected function validatedPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->is_agent == Customer::AGENT) {
                    $customerId = Auth::guard('customer')->user()->id;
                    $price = $this->trackAgent()->where('customer_id', $customerId)->first();
                    if ($price != null) {
                        return $price->price;
                    }
                }

                return $this->price;
            },
        );
    }

    protected function dataSourceDisplay(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->data_source == EkajayaService::class) {
                    return (new Setting)->getValue('EKAJAYA_MARK');
                }

                if ($this->data_source == GlobaltixService::class) {
                    return 'By Ekajaya ; ';
                }

                return '';
            },
        );
    }

    protected function alternativeName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->data_source == GlobaltixService::class) {
                    $data = json_decode($this->attribute_json);
                    if (auth('web')->check()) {
                        return $data->ticket_type->option_name . ' (' . $data->id . '|' . $data->ticket_type->id . ')';
                    }

                    return $data->ticket_type->option_name;
                }

                if ($this->group != null && $this->group?->fastboat != null) {
                    $name = $this->group?->fastboat->name . " (" . $this->source->name . " - " . $this->destination->name . ")";
                    return $name;
                }

                return '';
            },
        );
    }

    protected function timeText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->arrival_time . ' - ' . $this->departure_time;
            }
        );
    }

    public function detail($date, $dropoff, $price)
    {
        $detail = "<p>$this->order_detail (Fastboat)</p>
        <p>$this->arrival_time - $this->departure_time</p>
        <p>" . Carbon::parse($date)->format('d-m-Y') . '</p>';

        if ($dropoff != null) {
            $detail .= "<p>Dropoff: $dropoff</p>";
        }

        $detail .= '<p>@ ' . number_format($price, '0', ',', ' .') . '</p>';

        $detail .= "<p>$this->data_source_display </p>";

        return $detail;
    }

    public function getCapacity($date)
    {
        if ($this->data_source == GlobaltixService::class) {
            $data = json_decode($this->attribute_json);
            $capacity = GlobaltixService::getCheckAvailability($data->ticket_type->id, $date, $data->ticket_type->time_slot);
            $this->total = $capacity['total'];

            return $capacity['available'];
        }

        $cap = FastboatTrackOrderCapacity::where([
            'fastboat_track_group_id' => $this->fastboat_track_group_id,
            'fastboat_source_id' => $this->fastboat_source_id,
            'fastboat_destination_id' => $this->fastboat_destination_id,
        ])
            ->whereDate('date', Carbon::parse($date))
            ->first();

        if ($cap != null) {
            return $cap->capacity;
        }

        if ($this->group == null) {
            return 0;
        }

        return $this->group->fastboat->capacity;
    }

    public static function updateTrackUsage(FastboatTrack $track, $date, $quantity)
    {
        // uneed update track usage for global tix
        if ($track->data_source == GlobaltixService::class) {
            return;
        }

        // $tracks = $track->group->tracks;
        $fastboat = $track->group->fastboat;
        $places = $track->group->places()->orderBy('order', 'asc')->get();

        // other track that impact
        $n = $places->count();
        $places = $places->toArray();
        $startIndex = null;
        $endIndex = null;
        foreach ($places as $k => $place) {
            $isStart = $track->fastboat_source_id == $places[$k]['fastboat_place_id'];
            if ($startIndex == null && $isStart) {
                $startIndex = $k;
            }
            $isEnd = $track->fastboat_destination_id == $places[$k]['fastboat_place_id'];
            if ($endIndex == null && $isEnd) {
                $endIndex = $k;
            }
        }

        for ($i = 0; $i < $n; $i++) { // 1 2 3 4
            $isStart = $track->fastboat_source_id == $places[$i]['fastboat_place_id'];
            for ($j = $i + 1; $j < $n; $j++) { // 2 3 4
                $isEnd = $track->fastboat_destination_id == $places[$j]['fastboat_place_id'];
                $from = $places[$i]['fastboat_place_id'];
                $to = $places[$j]['fastboat_place_id'];
                // $rou = $from.'|'.$to;
                $capacity = FastboatTrackOrderCapacity::firstOrCreate([
                    'fastboat_track_group_id' => $track->group->id,
                    'fastboat_source_id' => $from,
                    'fastboat_destination_id' => $to,
                    'date' => $date,
                ], [
                    'capacity' => $fastboat->capacity,
                ]);
                if ($isStart || $isEnd) {
                    $capacity->update(['capacity' => $capacity->capacity - $quantity]);
                    // diantara 2 titik adalah lebih besar dari titik awal dan lebih kecil dari titik akhir
                } elseif ($startIndex < $i && $endIndex > $j) {
                    $capacity->update(['capacity' => $capacity->capacity - $quantity]);
                    // lainnya
                } elseif ($startIndex > $i && $endIndex < $j) {
                    $capacity->update(['capacity' => $capacity->capacity - $quantity]);
                } else {
                    // nothing todo
                }
            }
        }
    }
}
