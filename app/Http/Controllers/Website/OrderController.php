<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\FastboatTrack;
use App\Models\Order;
use App\Models\Setting;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        if(auth('customer')->check()) {
            // user
        } else {
            if(session('carts') == null) { 
                return redirect()->route('home.index');
            }
            $carts = collect(session('carts'))->map(function($cart, $id) {
                $track = $cart['type']::find($id);

                if($track instanceof FastboatTrack) {
                    $detail = $track->detail($cart['date']);
                }
                return [
                    'id' => $track->id,
                    'name' => $track->order_detail,
                    'detail' => $detail,
                    'price' => $track->price,
                    'qty' => $cart['qty'],
                    'type' => $cart['type'],
                    'date' => $cart['date']
                ];
            });
        }

        return view('cart', [
            'carts' => $carts
        ]);
    }

    public function payment(Order $order)
    {
        if($order->payment_token == null) { 
            $token = (new MidtransService($order, Setting::getByKey('midtrans_server_key')))->getSnapToken();
            $order->update(['payment_token' => $token]);
        } else { 
            $token = $order->payment_token;
        }
        return view('payment', [
            'order' => $order,
            'snap_token' => $token,
        ]);
    }

    public function payment_update(Request $request, Order $order)
    {
        $order->update([
            'payment_status' => $request->payment_status,
            'payment_response' => json_encode($request->result),
            'payment_channel' => $request->result['transaction_status'],
            'payment_type' => $request->result['payment_type'],
        ]);

        // TODO: send email that order has been payed if status is 1

        return response()->json([
            'show' => route('customer.order', $order)
        ]);
    }

    public function show(Order $order)
    {
        return view('order', [
            'order' => $order->load(['items', 'customer']),
        ]);
    }
}
