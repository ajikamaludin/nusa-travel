<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderPayment;
use App\Models\Customer;
use App\Models\FastboatDropoff;
use App\Models\FastboatTrack;
use App\Models\FastboatTrackOrderCapacity;
use App\Models\FastTrackGroupAgents;
use App\Models\Order;
use App\Services\AsyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\DateTime;
use Response;

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

    public function listPriceAgent(Request $request)
    {
        if (Auth::guard('authtoken')->check()) {
            $customerId = Auth::guard('authtoken')->user()->id;
            $query = FastTrackGroupAgents::query()->with('trackGroup.fastboat', 'customer')
                ->join('fastboat_track_agents', 'fastboat_track_agents.fast_track_group_agents_id', '=', 'fast_track_group_agents.id')
                ->select('fast_track_group_agents.*', DB::raw('sum(fastboat_track_agents.price) as price'))
                ->whereHas('customer', function ($query) use ($customerId) {
                    $query->where('customers.id', '=', $customerId);
                })
                ->groupBy('fast_track_group_agents.id');
        }

        return $query->get();
    }

    public function gettracks(Request $request)
    {
        $queryDeparture = FastboatTrack::with(['source', 'destination', 'group.fastboat']);
        if ($request->has(['from'])) {
            $queryDeparture->whereHas('source', function ($query) use ($request) {
                $query->where('name', '=', $request->from);
            });
        }
        if ($request->has(['to'])) {
            $queryDeparture->whereHas('destination', function ($query) use ($request) {
                $query->where('name', '=', $request->to);
            });
        }
        if ($request->has(['date'])) {
            $rdate = new DateTime($request->date);
            if ($rdate == now()) {
                $queryDeparture->whereTime('arrival_time', '>=', now());
            }
          
        }

        if (Auth::guard('authtoken')->check()) {
            $customerId = Auth::guard('authtoken')->user()->id;
            $queryDeparture->Leftjoin('fastboat_track_agents', 'fastboat_track_id', '=', 'fastboat_tracks.id')
                ->select('fastboat_tracks.id as id', 'fastboat_tracks.fastboat_track_group_id', 'fastboat_source_id', 'fastboat_destination_id', 'arrival_time', 'departure_time', DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'), 'is_publish', 'fastboat_tracks.created_at', 'fastboat_tracks.updated_at', 'fastboat_tracks.created_by')
                ->where('customer_id', '=', $customerId);
        }
        $fect = $queryDeparture->paginate();
        $data = $fect->map(function ($track) {
            return collect([
                'id' => $track?->id,
                'fastboat' => $track?->group?->fastboat?->name,
                'from' => $track?->destination?->name,
                'to' => $track?->source?->name,
                'destination' => $track?->group?->name,
                'arrival_time' => $track->arrival_time,
                'departure_time' => $track->departure_time,
                'price' => $track->price,
                'capacity' => $track?->group?->fastboat?->capacity,
            ]);
        });

        return $data;
    }
    public function orderAgent(Request $request)
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
            'order.detail_order.track_id' => 'required|string',
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

        $type = "App\Models\FastboatTrack";
        $from = $request->order['detail_order']['from'];
        $to = $request->order['detail_order']['to'];
        $trackId = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
            ->where('id', '=', $request->order['detail_order']['track_id'])
            ->first();
            $cap = FastboatTrackOrderCapacity::where([
                'fastboat_track_group_id' => $trackId->fastboat_track_group_id,
                'fastboat_source_id' => $trackId->fastboat_source_id,
                'fastboat_destination_id' => $trackId->fastboat_destination_id,
                'date' => $request->order['date'],
            ])->first();
    
            if($cap != null) {
                return $cap->capacity;
            }
    
        if (empty($trackId)||$cap<$request->order['qty']) {
            DB::rollBack();
            return Response("Failed", 400);
        }

        $item = $order->items()->create([
            'entity_order' => $type,
            'entity_id' => $trackId->id,
            'description' => $from . ' - ' . $to . ' | ' . $request->order['date'],
            'amount' => $request->order['detail_order']['price'],
            'quantity' => $request->order['qty'],
            'date' => $request->order['date'],
            'dropoff' => $dropoff?->name,
            'dropoff_id' => $dropoff?->id,
        ]);

        // // update every track ordered pending
        $track = FastboatTrack::find($trackId->id);
        FastboatTrack::updateTrackUsage($track, $request->order['date'], $request->order['qty']);

        // // insert every person in order to every item
        foreach ($request->persons as $index => $person) {
            $item->passengers()->create([
                'customer_id' => $index == 0 ? $customer->id : null,
                'nation' => $person['nation'],
                'national_id' => $person['national_id'],
                'name' => $person['name'],
            ]);
        }

        // AsyncService::async(function () use ($customer, $order) {
        //     Mail::to($customer->email)->send(new OrderPayment($order));
        // });
        // redirect to payment
        DB::commit();

        return Response("Succses", 200);
    }
    public function drop_off(Request $request)
    {
        $query = FastboatDropoff::query();
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }
        $offsite = 0;
        $limit = 10;
        return $query->limit($limit)->offset($offsite)->get();
    }
}