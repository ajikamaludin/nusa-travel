<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FastboatTracksCollection;
use App\Http\Resources\PickupsCollection;
use App\Models\Customer;
use App\Models\FastboatPickup;
use App\Models\FastboatTrack;
use App\Models\FastboatTrackAgent;
use App\Models\Order;
use App\Models\OrderItemPassenger;
use App\Models\Setting;
use App\Services\AsyncService;
use App\Services\EkajayaService;
use App\Services\GlobaltixService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query()
            ->where('is_agent', Customer::AGENT)
            ->where('is_active', Customer::ACTIVE);

        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        return $query->get();
    }

    public function tracks(Request $request)
    {
        $customerId = Auth::guard('authtoken')->user()->id;

        $query = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
            ->leftJoin('fastboat_track_agents', function ($join) use ($customerId) {
                $join->on('fastboat_track_id', '=', 'fastboat_tracks.id');
                $join->where('fastboat_track_agents.customer_id', '=', $customerId);
            })
            ->leftJoin('fastboat_track_groups', 'fastboat_track_groups.id', '=', 'fastboat_tracks.fastboat_track_group_id')
            ->leftJoin('fastboats', 'fastboats.id', '=', 'fastboat_track_groups.fastboat_id')
            ->select(
                'fastboat_tracks.id as id',
                'fastboat_tracks.fastboat_track_group_id',
                'fastboat_tracks.fastboat_source_id',
                'fastboat_tracks.fastboat_destination_id',
                'arrival_time',
                'departure_time',
                DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'),
                'is_publish',
                'fastboat_tracks.created_at',
                'fastboat_tracks.updated_at',
                'fastboat_tracks.created_by',
                'fastboats.capacity as capacity',
                'fastboat_tracks.data_source',
                'fastboat_tracks.attribute_json',
            );

        if ($request->from != '' && $request->to != '' && $request->date != '') {
            EkajayaService::search($request->from, $request->to, $request->date, 1);

            $query->whereHas('source', function ($query) use ($request) {
                $query->where('name', '=', $request->from);
            });

            $query->whereHas('destination', function ($query) use ($request) {
                $query->where('name', '=', $request->to);
            });

            $rdate = Carbon::createFromFormat('Y-m-d', $request->date);
            if ($rdate->isToday()) {
                $query->whereTime('arrival_time', '>=', now());
            }

            $query->leftJoin('fastboat_track_order_capacities', function ($join) use ($request) {
                $join->on('fastboat_track_order_capacities.fastboat_track_group_id', '=', 'fastboat_tracks.fastboat_track_group_id');
                $join->on('fastboat_track_order_capacities.fastboat_source_id', '=', 'fastboat_tracks.fastboat_source_id');
                $join->on('fastboat_track_order_capacities.fastboat_destination_id', '=', 'fastboat_tracks.fastboat_destination_id');
                $join->where('fastboat_track_order_capacities.date', '=', $request->date);
            });

            $query->select(
                'fastboat_tracks.id as id',
                'fastboat_tracks.fastboat_track_group_id',
                'fastboat_tracks.fastboat_source_id',
                'fastboat_tracks.fastboat_destination_id',
                'arrival_time',
                'departure_time',
                DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'),
                'is_publish',
                'fastboat_tracks.created_at',
                'fastboat_tracks.updated_at',
                DB::raw('COALESCE (fastboat_track_order_capacities.capacity,fastboats.capacity) as capacity'),
                'fastboat_tracks.data_source',
                'fastboat_tracks.attribute_json',
            );
        }

        return new FastboatTracksCollection($query->get());
    }

    public function order(Request $request)
    {
        $request->validate([
            'persons' => 'required|array',
            'persons.*.name' => 'required|string|max:255|min:3',
            'persons.*.nation' => 'required|string|in:WNA,WNI',
            'persons.*.national_id' => 'required|numeric',
            'persons.*.type' => 'nullable|in:0,1',
            'order' => 'required|array',
            'order.date' => 'required|date|after:yesterday',
            'order.qty' => 'required|numeric',
            'order.price' => 'required|numeric',
            'order.total_payed' => 'required|numeric',
            'order.track_id' => 'required|string|exists:fastboat_tracks,id',
            'pay_with_credit' => 'required|in:0,1',
        ]);

        if (count($request->persons) < $request->order['qty']) {
            return response()->json([
                'message' => 'Failed',
                'details' => 'Persons must be match with order.qty',
            ], 400);
        }

        DB::beginTransaction();

        $customerId = Auth::guard('authtoken')->user()->id;
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customerId,
            'total_amount' => $request->order['total_payed'],
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
            'payment_channel' => Setting::DEPOSITE_AGENT,
        ]);

        $balance = $order->customer->deposite_balance;
        // harga normal
        $track = FastboatTrack::where('id', $request->order['track_id'])->first();
        $price = $track->price;
        // harga agent
        $trackAgent = FastboatTrackAgent::where([
            ['customer_id', '=', $customerId],
            ['fastboat_track_id', '=', $request->order['track_id']],
        ])->first();
        if ($trackAgent != null) {
            $price = $trackAgent->price;
        }
        $totalOrder = $price * $request->order['qty'];
        if ($request->pay_with_credit == 1 && $totalOrder <= $balance) {
            $order->customer->update(['deposite_balance' => $balance - $totalOrder]);
            $order->customer->depositeHistories()->create([
                'credit' => $totalOrder,
                'description' => 'Payed for Order #'.$order->order_code,
            ]);

            $order->update([
                'payment_status' => Order::PAYMENT_SUCESS,
            ]);
        }

        $track = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
            ->where('id', $request->order['track_id'])
            ->first();

        $capacity = $track->getCapacity($request->order['date']);

        if ($capacity < $request->order['qty']) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed',
                'details' => 'Track seat not enough for order',
            ], 400);
        }

        $item = $order->items()->create([
            'entity_order' => FastboatTrack::class,
            'entity_id' => $track->id,
            'description' => $track->source->name.' - '.$track->destination->name.' | '.$request->order['date'],
            'amount' => $request->order['price'],
            'quantity' => $request->order['qty'],
            'date' => $request->order['date'],
        ]);

        // update every track ordered pending
        FastboatTrack::updateTrackUsage($track, $request->order['date'], $request->order['qty']);

        // insert every person in order to every item
        foreach ($request->persons as $index => $person) {
            $item->passengers()->create([
                'customer_id' => $index == 0 ? $customerId : null,
                'nation' => $person['nation'],
                'national_id' => $person['national_id'],
                'name' => $person['name'],
                'type' => $person['type'] ?? OrderItemPassenger::TYPE_PERSON,
            ]);
        }

        if ($track->data_source == EkajayaService::class) {
            AsyncService::async(function () use ($item) {
                EkajayaService::order($item);
            });
        }

        if ($track->data_source == GlobaltixService::class) {
            AsyncService::async(function () use ($item) {
                GlobaltixService::order($item);
            });
        }

        DB::commit();

        return response()->json([
            'message' => 'Succses',
            'details' => 'Order recorded',
        ], 201);
    }

    public function pickups(Request $request)
    {
        $query = FastboatPickup::query()->with(['car', 'source']);
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        return new PickupsCollection($query->paginate());
    }
}
