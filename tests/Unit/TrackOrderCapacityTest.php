<?php

namespace Tests\Unit;

use App\Models\Fastboat;
use App\Models\FastboatPlace;
use App\Models\FastboatTrack;
use App\Models\FastboatTrackGroup;
use App\Models\FastboatTrackOrderCapacity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TrackOrderCapacityTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /**
     * A basic unit test example.
     */
    public function test_the_route_order_capacity(): void
    {
        $this->seed('DatabaseSeeder');

        $fastboat = Fastboat::create([
            'number' => Str::random(2),
            'name' => Str::random(4),
            'capacity' => 20,
        ]);

        $place_0 = FastboatPlace::create([
            'name' => '0',
        ]);
        $place_1 = FastboatPlace::create([
            'name' => '1',
        ]);
        $place_2 = FastboatPlace::create([
            'name' => '2',
        ]);
        $place_3 = FastboatPlace::create([
            'name' => '3',
        ]);

        $places = [$place_0, $place_1, $place_2, $place_3];
        $group = FastboatTrackGroup::create([
            'fastboat_id' => $fastboat->id,
            'name' => $place_0->name.' - '.$place_2->name,
        ]);

        foreach ($places as $i => $place) {
            $group->places()->create([
                'fastboat_place_id' => $place->id,
                'order' => $i + 1,
            ]);
            for ($j = $i + 1; $j < count($places); $j++) {
                $group->tracks()->create([
                    'fastboat_source_id' => $place->id,
                    'fastboat_destination_id' => $places[$j]->id,
                    'price' => 50000,
                    'arrival_time' => '11:00:00',
                    'departure_time' => '13:00:00',
                    'is_publish' => 1,
                ]);
            }
        }

        // end to end order 1- 4
        /**
         * 0 1 2 3, 20
         * 0 -> 1 18 -
         * 0 -> 2 18 -
         * 0 -> 3 18 [v]
         * 1 -> 2 18 -
         * 1 -> 3 18 -
         * 2 -> 3 18 -

         * 0 -> 3,  2
         */
        $track = FastboatTrack::where([
            'fastboat_source_id' => $place_0->id,
            'fastboat_destination_id' => $place_3->id,
        ])->first();

        $tracks = $track->group->tracks;
        $date = now()->format('d-m-Y');
        $order = 2;

        FastboatTrack::updateTrackUsage($track, $date, $order);

        $capacities = [];
        $datas = [];
        $data = [18, 18, 18, 18, 18, 18];
        foreach($tracks as $i => $t) {
            $capacity = FastboatTrackOrderCapacity::where([
                'fastboat_track_group_id' => $track->group->id,
                'fastboat_source_id' => $t->fastboat_source_id,
                'fastboat_destination_id' => $t->fastboat_destination_id,
                'date' => $date,
            ])->first();

            $rou = $t->source->name.'|'.$t->destination->name;
            $capacities[$i] = [$rou, $capacity->capacity];
            $datas[$i] = [$rou, $data[$i]];
        }

        $this->assertEquals($datas, $capacities);

        // second order 1 - 2
        // end to end order
        /**
         * 0 1 2 3, 20, 18
         * 0 -> 1 16 [v]
         * 0 -> 2 16 -
         * 0 -> 3 16 -
         * 1 -> 2 18 x
         * 1 -> 3 18 x
         * 2 -> 3 18 x
         *
         * 0 -> 1,  2
         */
        $track = FastboatTrack::where([
            'fastboat_source_id' => $place_0->id,
            'fastboat_destination_id' => $place_1->id,
        ])->first();

        $tracks = $track->group->tracks;
        $order = 2;

        FastboatTrack::updateTrackUsage($track, $date, $order);

        $capacities = [];
        $datas = [];
        $data = [16, 16, 16, 18, 18, 18];
        foreach($tracks as $i => $t) {
            $capacity = FastboatTrackOrderCapacity::where([
                'fastboat_track_group_id' => $track->group->id,
                'fastboat_source_id' => $t->fastboat_source_id,
                'fastboat_destination_id' => $t->fastboat_destination_id,
                'date' => $date,
            ])->first();

            $rou = $t->source->name.'|'.$t->destination->name;
            $capacities[$i] = [$rou => $capacity->capacity];
            $datas[$i] = [$rou => $data[$i]];
        }

        $this->assertEquals($datas, $capacities);

        // third order 1 - 3
        // end to end order
        /**
         * 0 1 2 3, 20, 18, 16
         * 0 -> 1 16 x
         * 0 -> 2 14 -
         * 0 -> 3 14 -
         * 1 -> 2 16 [v]
         * 1 -> 3 16 x
         * 2 -> 3 18 x

         * 1 -> 2,  2
         */
        // titik awal lebih kecil dari titik awal order, dan titik akhir lebih besar dari order titik akhir
        $track = FastboatTrack::where([
            'fastboat_source_id' => $place_1->id,
            'fastboat_destination_id' => $place_2->id,
        ])->first();

        $tracks = $track->group->tracks;
        $order = 2;

        FastboatTrack::updateTrackUsage($track, $date, $order);

        $capacities = [];
        $datas = [];
        $data = [16, 14, 14, 16, 16, 18];
        foreach($tracks as $i => $t) {
            $capacity = FastboatTrackOrderCapacity::where([
                'fastboat_track_group_id' => $track->group->id,
                'fastboat_source_id' => $t->fastboat_source_id,
                'fastboat_destination_id' => $t->fastboat_destination_id,
                'date' => $date,
            ])->first();

            $rou = $t->source->name.'|'.$t->destination->name;
            $capacities[$i] = [$rou => $capacity->capacity];
            $datas[$i] = [$rou => $data[$i]];
        }

        $this->assertEquals($datas, $capacities);

        // #4 order 2 - 3
        // end to end order
        /**
         * 0 1 2 3, 20, 18, 16
         * 0 -> 1 16 x
         * 0 -> 2 14 x
         * 0 -> 3 12 -
         * 1 -> 2 16 x
         * 1 -> 3 14 -
         * 2 -> 3 16 [x]

         * 2 -> 3,  2
         */
        // titik awal lebih kecil dari titik awal order, dan titik akhir lebih besar dari order titik akhir
        $track = FastboatTrack::where([
            'fastboat_source_id' => $place_2->id,
            'fastboat_destination_id' => $place_3->id,
        ])->first();

        $tracks = $track->group->tracks;
        $order = 2;

        FastboatTrack::updateTrackUsage($track, $date, $order);

        $capacities = [];
        $datas = [];
        $data = [16, 14, 12, 16, 14, 16];
        foreach($tracks as $i => $t) {
            $capacity = FastboatTrackOrderCapacity::where([
                'fastboat_track_group_id' => $track->group->id,
                'fastboat_source_id' => $t->fastboat_source_id,
                'fastboat_destination_id' => $t->fastboat_destination_id,
                'date' => $date,
            ])->first();

            $rou = $t->source->name.'|'.$t->destination->name;
            $capacities[$i] = [$rou => $capacity->capacity];
            $datas[$i] = [$rou => $data[$i]];
        }

        $this->assertEquals($datas, $capacities);
        $this->assertTrue(true);
    }

    public function test_the_route_order_capacity_dinamic(): void
    {
        $this->seed('DatabaseSeeder');

        $fastboat = Fastboat::create([
            'number' => Str::random(2),
            'name' => Str::random(4),
            'capacity' => 20,
        ]);

        $min = 4;
        $max = 90;
        $manyPlaces = $max;
        $places = [];

        foreach(range(0, $manyPlaces) as $p) {
            $place_x = FastboatPlace::create([
                'name' => $p,
            ]);
            $places[$p] = $place_x;
        }

        $collection_places = collect($places);

        $this->assertEquals(count($places), $collection_places->count());
        $group = FastboatTrackGroup::create([
            'fastboat_id' => $fastboat->id,
            'name' => $collection_places->first()->name.' - '.$collection_places->last()->name,
        ]);

        foreach ($places as $i => $place) {
            $group->places()->create([
                'fastboat_place_id' => $place->id,
                'order' => $i + 1,
            ]);
            for ($j = $i + 1; $j <= $manyPlaces; $j++) {
                $group->tracks()->create([
                    'fastboat_source_id' => $place->id,
                    'fastboat_destination_id' => $places[$j]->id,
                    'price' => 50000,
                    'arrival_time' => '11:00:00',
                    'departure_time' => '13:00:00',
                    'is_publish' => 1,
                ]);
            }
        }

        $this->assertEquals(count($places), $group->places()->count());

        $start = rand(0, $max - 1);
        $end = rand($start + 1, $max - 1);

        $place1 = $collection_places[$start]; // 0 1 2 3 // 1
        $place2 = $collection_places[$end]; //

        $track = FastboatTrack::where([
            'fastboat_source_id' => $place1->id,
            'fastboat_destination_id' => $place2->id,
        ])->first();

        $tracks = $track->group->tracks;
        $date = now()->format('d-m-Y');
        $order = 2;

        FastboatTrack::updateTrackUsage($track, $date, $order);

        $capacities = [];
        $datas = [];

        $startIndex = null;
        $endIndex = null;

        $trackArray = $track->group->places->load(['place'])->toArray();
        foreach($trackArray as $k => $place) {
            $isStart = $track->fastboat_source_id == $place['fastboat_place_id'];
            if($startIndex == null && $isStart) {
                $startIndex = $k;
            }
            $isEnd = $track->fastboat_destination_id == $place['fastboat_place_id'];
            if($endIndex == null && $isEnd) {
                $endIndex = $k;
            }
        }

        for ($i = 0; $i < count($trackArray); $i++) {
            $isStart = $track->fastboat_source_id == $trackArray[$i]['fastboat_place_id'];
            for ($j = $i + 1; $j < count($trackArray); $j++) {
                $isEnd = $track->fastboat_destination_id == $trackArray[$j]['fastboat_place_id'];
                $from = $trackArray[$i]['place']['name'];
                $to = $trackArray[$j]['place']['name'];
                $rou = $from.'|'.$to;
                if ($isStart || $isEnd) {
                    $datas[] = [$rou, $fastboat->capacity - $order];
                // diantara 2 titik adalah lebih besar dari titik awal dan lebih kecil dari titik akhir
                } elseif ($startIndex < $i && $endIndex > $j) {
                    $datas[] = [$rou, $fastboat->capacity - $order];
                // lainnya
                } elseif ($startIndex > $i && $endIndex < $j) {
                    $datas[] = [$rou, $fastboat->capacity - $order];
                } else {
                    $datas[] = [$rou, $fastboat->capacity];
                }
            }
        }

        foreach($tracks as $i => $t) {
            $capacity = FastboatTrackOrderCapacity::where([
                'fastboat_track_group_id' => $track->group->id,
                'fastboat_source_id' => $t->fastboat_source_id,
                'fastboat_destination_id' => $t->fastboat_destination_id,
                'date' => $date,
            ])->first();

            $rou = $t->source->name.'|'.$t->destination->name;
            $capacities[$i] = [$rou, $capacity->capacity];
        }

        $this->assertEquals($datas, $capacities);
    }
}
