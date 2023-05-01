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

        $check = ! Cache::has($key);
        if (app()->isProduction() == false) {
            $check = true;
        }

        if ($check) {
            // cached for 1 hour, if has cache skip step below
            Cache::put($key, true, now()->addMinutes(15));

            // call api ekajaya for search
            $response = Http::acceptJson()
                ->withHeaders([
                    'authorization' => $apikey,
                ])->get($host.'/api/tracks', [
                    'from' => $source,
                    'to' => $destination,
                    'date' => $date,
                ]);

            $tracks = $response->json('data');

            Log::info('tracks response', [$tracks]);

            // if found result than record/upsert to db: tracks, capacities
            DB::beginTransaction();
            foreach ($tracks as $track) {
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
                        'data_source' => EkajayaService::class,
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
                        'name' => $track['from'].' - '.$track['to'],
                        'data_source' => EkajayaService::class,
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
                    'id' => $track['id'],
                ])->first();

                if ($fastboatTrack == null) {
                    $group->tracks()->create([
                        'id' => $track['id'],
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
                        'deleted_at' => null,
                    ]);
                }
            }

            // if no response check db for recorded placement
            if (count($tracks) == 0) {
                Log::info('tracks api clearing');
                // if no result fount than check db , if any remove record
                $s = FastboatPlace::where([
                    ['name', '=', $source],
                    ['data_source', '=', EkajayaService::class],
                ])->first();

                $d = FastboatPlace::where([
                    ['name', '=', $destination],
                    ['data_source', '=', EkajayaService::class],
                ])->first();

                if ($s != null && $d != null) {
                    $groups = FastboatTrackGroup::where([
                        ['name', '=', $s->name.' - '.$d->name],
                        ['data_source', '=', EkajayaService::class],
                    ])->get();

                    foreach ($groups as $group) {
                        $group->tracks()->where([
                            ['fastboat_source_id', '=', $s->id],
                            ['fastboat_destination_id', '=', $d->id],
                        ])->delete();

                        FastboatTrackOrderCapacity::where([
                            ['fastboat_track_group_id', '=', $group->id],
                        ])->delete();
                    }
                }
            }

            DB::commit();
        }
    }

    public static function order(OrderItem $item)
    {
        if ($item->entity_order != FastboatTrack::class) {
            Log::info('order not fastboat track');

            return;
        }

        $setting = Setting::getInstance();
        $enable = $setting->getValue('EKAJAYA_ENABLE');

        if ($enable == 0) {
            return;
        }

        $host = $setting->getValue('EKAJAYA_HOST');
        $apikey = $setting->getValue('EKAJAYA_APIKEY');

        $persons = [];
        foreach ($item->passengers as $passenger) {
            $persons[] = [
                'national_id' => $passenger['national_id'],
                'nation' => $passenger['nation'],
                'name' => $passenger['name'],
            ];
        }

        $response = Http::acceptJson()
            ->withHeaders([
                'authorization' => $apikey,
            ])->post($host.'/api/order', [
                'order' => [
                    'date' => $item->date,
                    'qty' => $item->quantity,
                    'price' => $item->amount,
                    'total_payed' => $item->quantity * $item->amount,
                    'track_id' => $item->entity_id,
                ],
                'persons' => $persons,
            ]);

        Log::info('order create response', [$response->json()]);
    }

    public static function clear()
    {
        FastboatTrack::where('data_source', EkajayaService::class)->delete();
        FastboatTrackGroup::where('data_source', EkajayaService::class)->delete();
        Fastboat::where('data_source', EkajayaService::class)->delete();
        FastboatPlace::where('data_source', EkajayaService::class)->delete();
    }
}
