<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FastboatOrder;
use App\Models\FastboatTrack;
use App\Models\Setting;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FastboatController extends Controller
{
    public function index(Request $request)
    {
        $query = FastboatTrack::query()->with(['source', 'destination']);

        if($request->has('from')) {
            $query->whereHas('source', function($query) use ($request) {
                $query->where('name', '=', $request->from);
            });
        }

        if($request->has('to')) {
            $query->whereHas('destination', function($query) use ($request) {
                $query->where('name', '=', $request->to);
            });
        }

        $query2 = null;

        if ($request->ways == 2) {
            $query2 = FastboatTrack::query()->with(['source', 'destination']);

            if($request->has('from')) {
                $query2->whereHas('source', function($query) use ($request) {
                    $query->where('name', '=', $request->to);
                });
            }

            if($request->has('to')) {
                $query2->whereHas('destination', function($query) use ($request) {
                    $query->where('name', '=', $request->from);
                });
            }
            $query2 = $query2->paginate(20, '*', 'track_two');
        }

        $date = now()->format('Y-m-d');
        if ($request->has('date')) {
            $date = Carbon::createFromFormat('Y-m-d',$request->date)->format('Y-m-d');
        }

        return view('fastboat', [
            'ways' => $request->ways,
            'from' => $request->from,
            'to' => $request->to,
            'date' => $date,
            'tracks_one' => $query->paginate(20),
            'tracks_two' => $query2,
        ]);
    }

    public function order(Request $request, FastboatTrack $track)
    {
        $order = FastboatOrder::create([
            'order_code' => Str::upper(Str::random(7)).now()->format('dmY'),
            'track_name' => $track->source->name.'-'.$track->destination->name,
            'fastboat_track_id' => $track->id,
            'customer_id' => Auth::guard('customer')->user()->id,
            'amount' => $track->price,
            'quantity' => $request->qty,
            'date' => now(),
            'arrival_time' => $track->arrival_time,
            'departure_time' => $track->departure_time,
            'payment_status' => 'Waiting Payment',
            'status' => FastboatOrder::UNPAID,
        ]);

        return view('fastboat-order',[
            'track' => $track,
            'qty' => $request->qty,
            'order' => $order,
        ]);
    }

    public function store(Request $request, FastboatOrder $order)
    {
        if($order->payment_token == null) {
            $serverKey = Setting::getByKey('midtrans_server_key');
            $token = (new MidtransService($order, $serverKey))->getSnapToken();
            $order->payment_token = $token;
            $order->save();
        }

        return response()->json([
            'order' => $order,
            'snap_token' => $order->payment_token
        ]); 
    }

    public function update(Request $request, FastboatOrder $order)
    {
        if($request->payment_status == '1') {
            $order->payment_status = FastboatOrder::PAID;
        }
        if($request->payment_status == '2') {
            $order->payment_status = FastboatOrder::FAILED;
        }
        if($request->payment_status == '3') {
            $order->payment_status = FastboatOrder::PENDING;
        }

        $order->payment_response = json_encode($request->input());
        $order->save();

        return response()->json(['show' => route('fastboat.show', $order)]);
    }

    public function show(FastboatOrder $order)
    {
        return view('fastboat-status',[
            'order' => $order,
        ]);
    }

    public function mine()
    {
        return view('fastboat-mine',[
            'orders' => Auth::guard('customer')->user()->orders,
        ]);
    }
}
