<?php

namespace Database\Seeders;

use App\Models\Fastboat;
use App\Models\FastboatDropoff;
use App\Models\FastboatPlace;
use App\Models\FastboatTrack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FastboatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->dropoff();
        $this->place();
        $this->fastboat();
        // $this->track();
    }


    public function dropoff()
    {
        $dropoff = [
            ['id' => Str::uuid(), 'name' => 'BANDARA'],
            ['id' => Str::uuid(), 'name' => 'PELABUHAN'],
            ['id' => Str::uuid(), 'name' => 'HOTEL'],
        ];

        FastboatDropoff::insert($dropoff);
    }

    public function place()
    {
        $places = [
            ['id' => Str::uuid(), 'name' => 'SERANGAN'],
            ['id' => Str::uuid(), 'name' => 'LEMBONGAN'],
            ['id' => Str::uuid(), 'name' => 'PENIDA'],
            ['id' => Str::uuid(), 'name' => 'PADANGBAI'],
            ['id' => Str::uuid(), 'name' => 'GILI TRAWANGAN'],
            ['id' => Str::uuid(), 'name' => 'MENO'],
            ['id' => Str::uuid(), 'name' => 'AIR'],
            ['id' => Str::uuid(), 'name' => 'BANGSAL'],
            ['id' => Str::uuid(), 'name' => 'SENGGIGI'],
        ];

        FastboatPlace::insert($places);
    }

    public function fastboat()
    {
        $fastboats = [
            ['id' => Str::uuid(), 'number' => 'CCX1', 'name' => 'Fastboat 1', 'capacity' => '20'],
            ['id' => Str::uuid(), 'number' => 'XXC2', 'name' => 'Fastboat 2', 'capacity' => '50'],
            ['id' => Str::uuid(), 'number' => 'CCC3', 'name' => 'Fastboat 3', 'capacity' => '100'],
        ];

        Fastboat::insert($fastboats);
    }

    public function track()
    {
        // TODO: ?
        // $fastboats = Fastboat::all();
        // $fastboat1 = $fastboats->first();
        // $fastboat2 = $fastboats->last();

        $SERANGAN = FastboatPlace::where('name', 'SERANGAN')->first()->id;
        $LEMBONGAN = FastboatPlace::where('name', 'LEMBONGAN')->first()->id;
        $PENIDA = FastboatPlace::where('name', 'PENIDA')->first()->id;
        $PADANGBAI = FastboatPlace::where('name', 'PADANGBAI')->first()->id;
        $GILI = FastboatPlace::where('name', 'GILI TRAWANGAN')->first()->id;
        $MENO = FastboatPlace::where('name', 'MENO')->first()->id;
        $AIR = FastboatPlace::where('name', 'AIR')->first()->id;
        $BANGSAL = FastboatPlace::where('name', 'BANGSAL')->first()->id;
        $SENGGIGI = FastboatPlace::where('name', 'SENGGIGI')->first()->id;

        // $groups = [
        //     [
        //         'fastboat_id' => $fastboat1->id,
        //         'name' => ''
        //     ]
        // ];

        // FastboatTrackGroup::create();

        $tracks = [
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $PENIDA,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $PENIDA,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $GILI,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $MENO,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $AIR,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $GILI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $MENO,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $AIR,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $GILI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $MENO,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $AIR,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $GILI,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $MENO,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $AIR,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
        ];

        $tracks = collect($tracks)->map(function ($track) {
            return [
                ...$track,
                "id" => Str::uuid(),
                "arrival_time" => "10:00",
                "departure_time" => "11:00",
                "is_publish" => "1",
            ];
        })->toArray();

        FastboatTrack::insert($tracks);
    }
}
