<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\OrderInvoice;
use App\Models\CarRental;
use App\Models\Customer;
use App\Models\FastboatTrack;
use App\Models\Order;
use App\Models\Setting;
use App\Models\TourPackage;
use App\Services\AsyncService;
use App\Services\DokuPaymentService;
use App\Services\GeneralService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $cart = [];
        if (auth('customer')->check()) {
            $order = Order::where([
                ['customer_id', '=', auth('customer')->user()->id],
                ['order_type', '=', Order::TYPE_CART],
            ])->with(['items'])->first();

            if ($order != null) {
                foreach ($order->items as $item) {
                    $cart[$item['entity_id']] = [
                        'qty' => $item['quantity'],
                        'type' => $item['entity_order'],
                        'date' => $item['date'],
                        'price' => $item['amount'],
                    ];
                }
            }
        } else {
            $cart = session('carts');
        }

        if ($cart == null) {
            return redirect()->route('home.index', ['locale' => GeneralService::getLocale('en')]);
        }

        $carts = collect($cart)->map(function ($cart, $id) {
            $entity = $cart['type']::find($id);
            if ($entity instanceof FastboatTrack) {
                return;
                /**
                 * remove fastboat from carts
                    $detail = $entity->detail($cart['date'], null, $entity->price);
                    $price = $entity->price;

                    return [
                        'id' => $entity->id,
                        'name' => $entity->order_detail,
                        'detail' => $detail,
                        'price' => $price,
                        'qty' => $cart['qty'],
                        'type' => $cart['type'],
                        'date' => $cart['date'],
                        'fastboat_cart' => '1',
                    ];
                 */
            }

            if ($entity instanceof CarRental) {
                $detail = $entity->detail($cart['date']);
                $price = $entity->price;
            }
            if ($entity instanceof TourPackage) {
                $detail = $entity->detail($cart['date'], $cart['price']);
                $price = $cart['price'];
            }

            if ($entity == null) {
                return;
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

        $carts = $carts->filter(function ($item) {
            if ($item != null) {
                return $item;
            }
        });

        if (in_array(null, $carts->toArray()) || count($carts->toArray()) == 0) {
            session()->remove('carts');

            return redirect()->route('home.index', ['locale' => GeneralService::getLocale('en')]);
        }

        session(['carts' => $carts]);

        return view('cart', [
            'carts' => $carts,
        ]);
    }

    public function payment(Request $request, Order $order)
    {
        if ($order->payment_channel == Setting::PAYMENT_MIDTRANS) {
            if ($order->payment_token == null) {
                $token = (new MidtransService($order, Setting::getByKey('midtrans_server_key')))->getSnapToken();
                $order->update(['payment_token' => $token]);
            } else {
                $token = $order->payment_token;
            }

            return view('payment.midtrans', [
                'order' => $order,
                'snap_token' => $token,
            ]);
        }

        if ($order->payment_channel == Setting::PAYMENT_DOKU) {
            if ($order->payment_token == null) {
                $doku = (new DokuPaymentService($order, Setting::getByKey('DOKU_CLIENT_ID'), Setting::getByKey('DOKU_SECRET_KEY')))->getPaymentUrl();
                if ($doku == null) {
                    throw new \Exception('Doku Error');
                }
                $doku = json_encode($doku);
                $order->update(['payment_token' => $doku]);
            }

            $doku = json_decode($order->payment_token);

            return view('payment.doku', [
                'order' => $order,
                'payment_url' => $doku->response->payment->url,
            ]);
        }

        if ($order->payment_channel == Setting::PAYMENT_DOKU_CREDIT) {
            if ($order->payment_token == null) {
                $doku = (new DokuPaymentService($order, Setting::getByKey('DOKU_CLIENT_ID'), Setting::getByKey('DOKU_SECRET_KEY')))->getCreditCardPaymentUrl();
                if ($doku == null) {
                    throw new \Exception('Doku Error');
                }
                $doku = json_encode($doku);
                $order->update(['payment_token' => $doku]);
            }

            $doku = json_decode($order->payment_token);

            return view('payment.doku_credit_card', [
                'order' => $order,
                'payment_url' => $doku->credit_card_payment_page->url,
            ]);
        }

        if ($order->payment_channel == Setting::DEPOSITE_AGENT) {
            if ($order->customer->is_agent != Customer::AGENT) {
                return redirect()->route('customer.orders')
                    ->with('message', ['type' => 'error', 'message' => 'Payment Rejected, Please contact site administrator']);
            }

            $balance = $order->customer->deposite_balance;
            if ($order->total_amount > $balance) {
                return redirect()->route('customer.orders')
                    ->with('message', ['type' => 'error', 'message' => 'Insufficient Balance']);
            }

            DB::beginTransaction();
            $order->customer->update(['deposite_balance' => $balance - $order->total_amount]);
            $order->customer->depositeHistories()->create([
                'credit' => $order->total_amount,
                'description' => 'Payed for Order #' . $order->order_code,
            ]);

            $order->update([
                'payment_status' => Order::PAYMENT_SUCESS,
            ]);

            AsyncService::async(function () use ($order) {
                Mail::to($order->customer->email)->send(new OrderInvoice($order));
            });

            DB::commit();

            return redirect()->route('customer.order', $order);
        }

        return redirect()->route('customer.orders')
            ->with('message', ['type' => 'error', 'message' => 'Order Payment not configure, Please contact site administrator']);
    }

    public function payment_update(Request $request, Order $order)
    {
        DB::beginTransaction();
        $order->update([
            'payment_status' => $request->payment_status,
            'payment_response' => json_encode($request->result),
            'payment_type' => $request->result['payment_type'],
        ]);

        // send email that order has been payed if status is 1
        if ($order->payment_status == Order::PAYMENT_SUCESS) {
            AsyncService::async(function () use ($order) {
                Mail::to($order->customer->email)->send(new OrderInvoice($order));
            });
        }

        DB::commit();

        return response()->json([
            'show' => route('customer.order', $order),
        ]);
    }

    public function payment_notification(Request $request)
    {
        DB::beginTransaction();
        $order = Order::where('id', $request->order_id)->first();

        if ($order != null && $order->payment_status != Order::PAYMENT_SUCESS) {
            $order->fill([
                'payment_response' => json_encode($request->all()),
                'payment_type' => $request->result['payment_type'],
            ]);

            if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                $order->fill(['payment_status' => Order::PAYMENT_SUCESS]);
                // send email that order has been payed if status is 1
                AsyncService::async(function () use ($order) {
                    Mail::to($order->customer->email)->send(new OrderInvoice($order));
                });
            } elseif ($request->transaction_status == 'pending') {
                $order->fill(['payment_status' => Order::PAYMENT_PENDING]);
            } else {
                $order->fill(['payment_status' => Order::PAYMENT_ERROR]);
            }

            $order->save();
        }

        DB::commit();

        return response()->json([
            'status' => 'ok',
            'order' => $order,
        ]);
    }

    public function payment_notification_doku(Request $request)
    {
        DB::beginTransaction();
        $order = Order::where('order_code', $request->order['invoice_number'])->first();

        if ($order != null && $order->payment_status != Order::PAYMENT_SUCESS) {
            $order->fill([
                'payment_response' => json_encode($request->all()),
                'payment_type' => $request->channel['id'],
            ]);

            if ($request->transaction['status'] == 'SUCCESS') {
                $order->fill(['payment_status' => Order::PAYMENT_SUCESS]);
                // send email that order has been payed if status is 1
                AsyncService::async(function () use ($order) {
                    Mail::to($order->customer->email)->send(new OrderInvoice($order));
                });
            } elseif ($request->transaction['status'] == 'FAILED') {
                $order->fill(['payment_status' => Order::PAYMENT_ERROR]);
            } else {
                $order->fill(['payment_status' => Order::PAYMENT_PENDING]);
            }

            $order->save();
        }

        DB::commit();

        return response()->json([
            'status' => 'ok',
            'order' => $order,
        ]);
    }

    public function show(Order $order)
    {
        return view('order', [
            'order' => $order->load(['items', 'customer', 'promos.promo']),
        ]);
    }

    public function orders()
    {
        $user = Auth::guard('customer')->user();
        $orders = Order::where('customer_id', $user->id)->where('order_type', Order::TYPE_ORDER);

        return view('customer.order', [
            'orders' => $orders->orderBy('payment_status', 'asc')->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function fastboat()
    {
        $carts = session()->get('carts') ?? [];

        if (count($carts) == 0) {
            return redirect()->route('home.index', ['locale' => GeneralService::getLocale('en')]);
        }

        return view('fastboat-cart');
    }
}
