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
use Illuminate\Support\Str;

class EkajayaService
{
    const key = 'api_integration:0x923810';

    public static function check($host)
    {
        $response = Http::acceptJson()->get($host . '/api');

        if ($response->json('app_name') != self::key) {
            return false;
        }

        return true;
    }

    public static function tracks()
    {
        $setting = Setting::getInstance();
        $enable = $setting->getValue('EKAJAYA_ENABLE');

        if ($enable == 0) {
            throw new \Exception('API Integration Not Enabled');

            return;
        }

        $host = $setting->getValue('EKAJAYA_HOST');
        $apikey = $setting->getValue('EKAJAYA_APIKEY');

        $key = 'all_tracks';

        $check = !Cache::has($key);
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
                ])->get($host . '/api/tracks');

            $tracks = $response->json('data');

            Log::info($key, [$tracks]);

            // if found result than record/upsert to db: tracks, capacities
            foreach ($tracks as $track) {
                self::handleUpdateTrack($track);
            }

            // if has been in database but deleted in api
            $dbcheck = FastboatTrack::where('data_source', EkajayaService::class);
            if (count($tracks) != $dbcheck->count()) {
                $excludeIds = collect($tracks)->pluck('id')->toArray();
                $dbcheck->whereNotIn('id', $excludeIds)->delete();
            }

            // if no response check db for recorded placement
            if (count($tracks) == 0) {
                self::clear();
            }

            DB::commit();
        }
    }

    public static function search($source, $destination, $date, $ways)
    {
        $setting = Setting::getInstance();
        $enable = $setting->getValue('EKAJAYA_ENABLE');

        if ($enable == 0) {
            return;
        }

        $host = $setting->getValue('EKAJAYA_HOST');
        $apikey = $setting->getValue('EKAJAYA_APIKEY');

        $key = $ways . '|' . $source . '_' . $destination . ':' . $date;

        $check = !Cache::has($key);
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
                ])->get($host . '/api/tracks', [
                    'from' => $source,
                    'to' => $destination,
                    'date' => $date,
                ]);

            $tracks = $response->json('data');

            Log::info('tracks response', [$tracks]);

            // if found result than record/upsert to db: tracks, capacities
            DB::beginTransaction();

            $places = [];
            foreach ($tracks as $track) {
                $places[] = self::handleUpdateTrack($track);
            }

            // if has been in database but deleted in api
            foreach ($places as $place) {
                self::removeDiscrepancy($place['source'], $place['destination'], $tracks);
            }

            // if no response check db for recorded placement
            if (count($tracks) == 0) {
                if (count($places) == 0) {
                    // no response at all
                    $source = FastboatPlace::where('name', $source)->where('data_source', EkajayaService::class)->first();
                    $destination = FastboatPlace::where('name', $destination)->where('data_source', EkajayaService::class)->first();
                    self::clearSpecific($source, $destination);
                }
                // spesific same place diff items
                foreach ($places as $place) {
                    self::clearSpecific($place['source'], $place['destination']);
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
            ])->post($host . '/api/order', [
                'order' => [
                    'date' => $item->date,
                    'qty' => $item->quantity,
                    'price' => $item->amount,
                    'total_payed' => $item->quantity * $item->amount,
                    'track_id' => $item->entity_id,
                ],
                'persons' => $persons,
                'pay_with_credit' => 1,
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

    private static function handleUpdateTrack(array $track): array
    {
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
        if ($track['source'] == GlobaltixService::class) {
            $fastboat = Fastboat::withTrashed()->where('name', $track['fastboat'])->first();
            $track['fastboat_id'] = Str::uuid();
        }
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
                'name' => $track['from'] . ' - ' . $track['to'],
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

        $fastboatTrack = $group->tracks()->withTrashed()->where('id', $track['id'])->first();
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
            $price = $track['price'];
            if ($fastboatTrack->attribute_json != null) {
                $price = $fastboatTrack->price;
            }
            $fastboatTrack->update([
                'arrival_time' => $track['arrival_time'],
                'departure_time' => $track['departure_time'],
                'price' => $price,
                'fastboat_source_id' => $source->id,
                'fastboat_destination_id' => $destination->id,
                'is_publish' => 1,
                'data_source' => EkajayaService::class,
                'deleted_at' => null,
            ]);
        }

        return [
            'source' => $source,
            'destination' => $destination,
        ];
    }

    private static function clearSpecific(FastboatPlace $source, FastboatPlace $destination)
    {
        Log::info('tracks api clearing');
        // if no result fount than check db , if any remove record
        if ($source != null && $destination != null) {
            $groups = FastboatTrackGroup::where([
                ['name', '=', $source->name . ' - ' . $destination->name],
                ['data_source', '=', EkajayaService::class],
            ])->get();

            foreach ($groups as $group) {
                $group->tracks()->where([
                    ['fastboat_source_id', '=', $source->id],
                    ['fastboat_destination_id', '=', $destination->id],
                ])->delete();

                FastboatTrackOrderCapacity::where([
                    ['fastboat_track_group_id', '=', $group->id],
                ])->delete();
            }
        }
    }

    private static function removeDiscrepancy(FastboatPlace $source, FastboatPlace $destination, array $tracks = [])
    {
        $dbcheck = FastboatTrack::where('fastboat_source_id', $source->id)
            ->where('fastboat_destination_id', $destination->id)
            ->where('data_source', EkajayaService::class);
        if (count($tracks) != $dbcheck->count()) {
            $excludeIds = collect($tracks)->pluck('id')->toArray();
            $dbcheck->whereNotIn('id', $excludeIds)->delete();
        }
    }
}
