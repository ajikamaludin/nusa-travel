<?php

namespace Database\Seeders;

use App\Models\CarRental;
use App\Models\Fastboat;
use App\Models\FastboatDropoff;
use App\Models\FastboatPickup;
use App\Models\FastboatPlace;
use App\Models\FastboatTrackGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FastboatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->place();
        $this->fastboat();
        $this->track();
        $this->dropoff();
        $this->pickup();
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

    public function pickup()
    {
        $SENGGIGI = FastboatPlace::where('name', 'SENGGIGI')->value('id');

        $pickup = [
            ['id' => Str::uuid(), 'name' => 'BANDARA', 'source_id' => $SENGGIGI, 'car_rental_id' => CarRental::value('id')],
            ['id' => Str::uuid(), 'name' => 'HOTEL', 'source_id' => $SENGGIGI, 'car_rental_id' => CarRental::value('id')],
            ['id' => Str::uuid(), 'name' => 'PELABUHAN', 'source_id' => $SENGGIGI, 'car_rental_id' => CarRental::value('id')],
            ['id' => Str::uuid(), 'name' => 'PANTAI', 'source_id' => $SENGGIGI, 'car_rental_id' => CarRental::value('id')],
        ];

        FastboatPickup::insert($pickup);
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
        $fastboats = Fastboat::get();

        $SENGGIGI = FastboatPlace::where('name', 'SENGGIGI')->first();
        $BANGSAL = FastboatPlace::where('name', 'BANGSAL')->first();
        $SERANGAN = FastboatPlace::where('name', 'SERANGAN')->first();

        $places = [$SENGGIGI, $BANGSAL, $SERANGAN];
        $groups = [
            [
                'fastboat_id' => $fastboats->first()->id,
                'name' => $SENGGIGI->name . ' - ' . $SERANGAN->name,
            ],
            [
                'fastboat_id' => $fastboats->last()->id,
                'name' => $SERANGAN->name . ' - ' . $SENGGIGI->name,
            ],
        ];

        DB::beginTransaction();
        foreach ($groups as $g => $group) {
            $group = FastboatTrackGroup::create($group);
            // tracks
            if ($g == 1) {
                $places = array_reverse($places);
            }
            foreach ($places as $index => $place) {
                $group->places()->create([
                    'fastboat_place_id' => $place->id,
                    'order' => $index + 1,
                ]);
            }
            foreach ($places as $i => $place) {
                for ($j = $i + 1; $j < count($places); $j++) {
                    $group->tracks()->create([
                        'fastboat_source_id' => $place->id,
                        'fastboat_destination_id' => $places[$j]->id,
                        'price' => $i == 0 && $j == 2 ? 100000 : 50000,
                        'arrival_time' => $i == 0 && $j == 2 ? '11:00:00' : 10 + $j + $g . ':00:00',
                        'departure_time' => $i == 0 && $j == 2 ? '13:00:00' : 11 + $j + $g . ':00:00',
                        'is_publish' => 1,
                    ]);
                }
            }
        }
        DB::commit();
    }
}
