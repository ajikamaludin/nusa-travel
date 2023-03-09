<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CarRental;
use App\Models\FastboatTrack;
use App\Models\Order;
use App\Models\Setting;
use App\Models\TourPackage;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $cart = [];
        if(auth('customer')->check()) {
            $order = Order::where([
                ['customer_id', '=', auth('customer')->user()->id],
                ['order_type', '=', Order::TYPE_CART]
            ])->with(['items'])->first();

            if($order != null) {
                foreach($order->items as $item) {
                    $cart[$item['entity_id']] = [
                        'qty' => $item['quantity'], 
                        'type' => $item['entity_order'], 
                        'date' => $item['date'],
                        'price' => $item['amount']
                    ];
                }
            }
        } else {
            $cart = session('carts');
        }

        if($cart == null) { 
            return redirect()->route('home.index');
        }

        $carts = collect($cart)->map(function($cart, $id) {
            $entity = $cart['type']::find($id);
            if($entity instanceof FastboatTrack) {
                $detail = $entity->detail($cart['date']);
                $price = $entity->price;
            }
            if($entity instanceof CarRental) {
                $detail = $entity->detail($cart['date']);
                $price = $entity->price;
            }
            if($entity instanceof TourPackage) {
                $detail = $entity->detail($cart['date'], $cart['price']);
                $price = $cart['price'];
            }
            return [
                'id' => $entity->id,
                'name' => $entity->order_detail,
                'detail' => $detail,
                'price' => $price,
                'qty' => $cart['qty'],
                'type' => $cart['type'],
                'date' => $cart['date'],
            ];
        });

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

    public function payment_notification(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();

        if($order != null && $order->payment_status != Order::PAYMENT_SUCESS) {
            $order->fill([
                'payment_response' => json_encode($request->all()),
                'payment_type' => $request->result['payment_type'],
                'payment_channel' => $request->result['transaction_status'],
            ]);

            if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                $order->fill(['payment_status' => Order::PAYMENT_SUCESS]);
            } elseif ($request->transaction_status == 'pending') {
                $order->fill(['payment_status' => Order::PAYMENT_PENDING]);
            } else {
                $order->fill(['payment_status' => Order::PAYMENT_ERROR]);
            }

            $order->save();
        }

        return response()->json([
            'status' => 'ok',
            'order'=> $order
        ]);
    }

    public function show(Order $order)
    {
        return view('order', [
            'order' => $order->load(['items', 'customer']),
        ]);
    }

    public function orders()
    {
        $user = Auth::guard('customer')->user();
        $orders = Order::where('customer_id', $user->id)->where('order_type', Order::TYPE_ORDER);
        return view('customer.order', [
            'orders' => $orders->orderBy('payment_status', 'desc')->orderBy('created_at', 'desc')->paginate(), 
        ]);
    }

    public function fastboat()
    {
        // 
    }
}
