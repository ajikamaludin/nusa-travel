<?php

namespace App\Services;

use App\Models\Fastboat;
use App\Models\FastboatPlace;
use App\Models\FastboatTrack;
use App\Models\FastboatTrackGroup;
use App\Models\FastboatTrackOrderCapacity;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EkajayaService
{
    public static function search($source, $destination, $date, $ways)
    {
        $setting = Setting::getInstance();
        $enable = $setting->getValue('EKAJAYA_ENABLE');

        if ($enable == 0) {
            return;
        }

        $host = $setting->getValue('EKAJAYA_HOST');
        $apikey = $setting->getValue('EKAJAYA_APIKEY');

        $key = $ways.'|'.$source.'_'.$destination.':'.$date;

        if(!Cache::has($key) && app()->isProduction() == true) { 
            // cached for 1 hour, if has cache skip step below
            Cache::put($key, true, now()->addHour());

            // call api ekajaya for search
            $response = Http::acceptJson()
            ->withHeaders([
                'authorization' => $apikey
            ])->get($host.'/api/tracks', [
                'from' => $source,
                'to' => $destination,
                'date' => $date,
            ]);

            $tracks = $response->json('data');

            Log::info('response', [$tracks]);

            // if found result than record/upsert to db: tracks, capacities
            DB::beginTransaction();
            foreach($tracks as $track) {
                $source = FastboatPlace::withTrashed()->where('id', $track['from_id'])->first();
                if ($source == null) {
                    $source = FastboatPlace::create([
                        'id' => $track['from_id'],
                        'name' => $track['from'],
                        'data_source' => EkajayaService::class,
                    ]);
                } else {
                    $source->update([
                        'name' => $track['from'],
                        'deleted_at' => null,
                    ]);
                }

                $destination = FastboatPlace::withTrashed()->where('id', $track['to_id'])->first();
                if ($destination == null) {
                    $destination = FastboatPlace::create([
                        'id' => $track['to_id'],
                        'name' => $track['to'],
                        'data_source' => EkajayaService::class,
                    ]);
                } else {
                    $destination->update(['name' => $track['to']]);
                }

                $fastboat = Fastboat::withTrashed()->where('id', $track['fastboat_id'])->first();
                if ($fastboat == null) {
                    $fastboat = Fastboat::create([
                        'id' => $track['fastboat_id'],
                        'name' => $track['fastboat'],
                        'capacity' => $track['capacity'],
                        'data_source' => EkajayaService::class
                    ]);
                } else {
                    $fastboat->update([
                        'name' => $track['fastboat'],
                        'capacity' => $track['capacity'],
                        'deleted_at' => null,
                    ]);
                }

                $group = FastboatTrackGroup::withTrashed()->where('fastboat_id', $fastboat->id)->first();
                if ($group == null) {
                    $group = FastboatTrackGroup::create([
                        'fastboat_id' => $fastboat->id,
                        'name' => $track['from'] . ' - ' . $track['to'],
                        'data_source' => EkajayaService::class
                    ]);
                } else {
                    $group->update(['deleted_at' => null]);
                }

                FastboatTrackOrderCapacity::where([
                    ['fastboat_track_group_id', '=', $group->id],
                    ['fastboat_source_id', '=', $source->id],
                    ['fastboat_destination_id', '=', $destination->id],
                ])->delete();

                $fastboatTrack = $group->tracks()->withTrashed()->where([
                    'fastboat_source_id' => $source->id,
                    'fastboat_destination_id' => $destination->id,
                    'is_publish' => 1,
                    'data_source' => EkajayaService::class,
                ])->first(); 

                if ($fastboatTrack == null) {
                    $group->tracks()->create([
                        'arrival_time' => $track['arrival_time'],
                        'departure_time' => $track['departure_time'],
                        'price' => $track['price'],
                        'fastboat_source_id' => $source->id,
                        'fastboat_destination_id' => $destination->id,
                        'is_publish' => 1,
                        'data_source' => EkajayaService::class,
                    ]);
                } else {
                    $fastboatTrack->update([
                        'arrival_time' => $track['arrival_time'],
                        'departure_time' => $track['departure_time'],
                        'price' => $track['price'],
                        'fastboat_source_id' => $source->id,
                        'fastboat_destination_id' => $destination->id,
                        'is_publish' => 1,
                        'data_source' => EkajayaService::class,
                        'deleted_at'=> null
                    ]);
                }
            }

            if(count($tracks) == 0) {
                // if no result fount than check db , if any remove record
                $source = Fastboat::where('name', $source)->first();
                $destination = Fastboat::where('name', $destination)->first();

                if($source != null && $destination != null) {
                    $group = FastboatTrackGroup::where([
                        ['name' => $source->name . ' - ' . $destination->name],
                        ['data_source', '=', EkajayaService::class]
                    ])->first(); 
    
                    if ($group != null) {
                        $group->tracks()->where([
                            ['fastboat_source_id', '=', $source->id],
                            ['fastboat_destination_id', '=', $destination->id],
                            ['data_source', '=', EkajayaService::class,]
                        ])->delete();

                        FastboatTrackOrderCapacity::where([
                            ['fastboat_track_group_id', '=', $group->id],
                            ['fastboat_source_id', '=', $source->id],
                            ['fastboat_destination_id', '=', $destination->id],
                        ])->delete();
                    }
                }
            }

            DB::commit();
        }
    }

    public static function order(OrderItem $order)
    {
        // TODO: send item ordered to ekajaya
    }

    public static function clear()
    {
        FastboatTrack::where('data_source', EkajayaService::class)->delete();
        FastboatTrackGroup::where('data_source', EkajayaService::class)->delete();
        Fastboat::where('data_source', EkajayaService::class)->delete();
        FastboatPlace::where('data_source', EkajayaService::class)->delete();
    }
}
