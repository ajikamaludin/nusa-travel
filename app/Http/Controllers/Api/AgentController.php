<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TracksCollection;
use App\Models\Customer;
use App\Models\FastboatDropoff;
use App\Models\FastboatTrack;
use App\Models\FastboatTrackOrderCapacity;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query()->where('is_agent', '1')->where('is_active', '1');
        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return $query->get();
    }

    public function tracks(Request $request)
    {
        $queryDeparture = FastboatTrack::with(['source', 'destination', 'group.fastboat']);

        $customerId = Auth::guard('authtoken')->user()->id;
        $queryDeparture->leftJoin('fastboat_track_agents', 'fastboat_track_id', '=', 'fastboat_tracks.id')
        ->join('fastboat_track_groups', 'fastboat_track_groups.id', '=', 'fastboat_tracks.fastboat_track_group_id')
        ->join('fastboats', 'fastboats.id', '=', 'fastboat_track_groups.fastboat_id')
        ->select('fastboat_tracks.id as id', 'fastboat_tracks.fastboat_track_group_id', 'fastboat_tracks.fastboat_source_id', 'fastboat_tracks.fastboat_destination_id', 'arrival_time', 'departure_time', DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'), 'is_publish', 'fastboat_tracks.created_at', 'fastboat_tracks.updated_at', 'fastboat_tracks.created_by', 'fastboats.capacity as capacity')
            ->where('customer_id', '=', $customerId);
        if ($request->has(['from']) && $request->has(['to']) && $request->has(['date'])) {
            $queryDeparture->whereHas('source', function ($query) use ($request) {
                $query->where('name', '=', $request->from);
            });
            $queryDeparture->whereHas('destination', function ($query) use ($request) {
                $query->where('name', '=', $request->to);
            });

            $rdate = new DateTime($request->date);
            if ($rdate == now()) {
                $queryDeparture->whereTime('arrival_time', '>=', now());
            }
            // $queryDeparture->whereHas('group', function ($query) use ($rdate) {
                $queryDeparture->leftJoin('fastboat_track_order_capacities', function ($join) use ($rdate) {
                    $join->on('fastboat_track_order_capacities.fastboat_track_group_id', '=', 'fastboat_tracks.fastboat_track_group_id');
                    $join->on('fastboat_track_order_capacities.fastboat_source_id', '=', 'fastboat_tracks.fastboat_source_id');
                    $join->on('fastboat_track_order_capacities.fastboat_destination_id', '=', 'fastboat_tracks.fastboat_destination_id')
                    ->where('fastboat_track_order_capacities.date', '=', $rdate);
                    // ;
                    // $queryDeparture->Select(DB::raw('COALESCE (fastboat_track_order_capacities.capacity,fastboats.capacity) as capacitys'));
                });
                $queryDeparture->Select('fastboat_tracks.id as id', 'fastboat_tracks.fastboat_track_group_id', 'fastboat_tracks.fastboat_source_id', 'fastboat_tracks.fastboat_destination_id', 'arrival_time', 'departure_time', DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'), 'is_publish', 'fastboat_tracks.created_at', 'fastboat_tracks.updated_at', 'fastboat_tracks.created_by', DB::raw('COALESCE (fastboat_track_order_capacities.capacity,fastboats.capacity) as capacity'));

            // });

        }

        $fect = $queryDeparture->paginate();

        return new TracksCollection($fect);

    }

    public function order(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'nation' => 'required|string',
            'national_id' => 'required|numeric',
            'email' => 'required|email',
            'persons' => 'required|array',
            'persons.*.name' => 'required|string|max:255|min:3',
            'persons.*.nation' => 'required|string',
            'persons.*.national_id' => 'required|numeric',
            'order' => 'required|array',
            'order.qty' => 'required|numeric',
            'order.type_order' => 'required|string',
            'order.date' => 'required|string',
            'order.total_payed' => 'required|numeric',
            'order.detail_order' => 'required|array',
            'order.detail_order.track_id' => 'required|string|exists:fastboat_tracks,id',
            'order.detail_order.fastboat' => 'required|string',
            'order.detail_order.from' => 'required|string',
            'order.detail_order.to' => 'required|string',
            'order.detail_order.price' => 'required|numeric',
            'order.detail_order.arrival_time' => 'required|string',
            'order.detail_order.departure_time' => 'required|string',
        ]);
        // dd($request->order);
        DB::beginTransaction();
        $customer = Customer::hardSearch(
            $request->phone,
            $request->national_id,
            $request->email,
            [
                'name' => $request->name,
                'nation' => $request->nation,
            ]
        );

        $dropoff = FastboatDropoff::where('name', $request->dropoff)->first();

        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customer->id,
            'total_amount' => $request->order['total_payed'],
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
        ]);

        $from = $request->order['detail_order']['from'];
        $to = $request->order['detail_order']['to'];

        $track = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
            ->where('id', $request->order['detail_order']['track_id'])
            ->first();

        $cap = FastboatTrackOrderCapacity::where([
            'fastboat_track_group_id' => $track->fastboat_track_group_id,
            'fastboat_source_id' => $track->fastboat_source_id,
            'fastboat_destination_id' => $track->fastboat_destination_id,
            'date' => $request->order['date'],
        ])->value('capacity');

        if ($cap != null) {
            $cap = $track->group->fastboat->capacity;
        }

        if ($cap < $request->order['qty']) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed',
                'details' => 'Track seat not enough for order',
            ], 400);
        }

        $item = $order->items()->create([
            'entity_order' => FastboatTrack::class,
            'entity_id' => $track->id,
            'description' => $from.' - '.$to.' | '.$request->order['date'],
            'amount' => $request->order['detail_order']['price'],
            'quantity' => $request->order['qty'],
            'date' => $request->order['date'],
            'dropoff' => $dropoff?->name,
            'dropoff_id' => $dropoff?->id,
        ]);

        // update every track ordered pending
        FastboatTrack::updateTrackUsage($track, $request->order['date'], $request->order['qty']);

        // insert every person in order to every item
        foreach ($request->persons as $index => $person) {
            $item->passengers()->create([
                'customer_id' => $index == 0 ? $customer->id : null,
                'nation' => $person['nation'],
                'national_id' => $person['national_id'],
                'name' => $person['name'],
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Succses',
            'details' => 'order recorded',
        ], 200);
    }

    public function dropoff(Request $request)
    {
        $query = FastboatDropoff::query();
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        return $query->paginate();
    }
}
