<?php

namespace App\Http\Controllers;

use App\Models\CarRental;
use App\Models\Customer;
use App\Models\FastboatTrack;
use App\Models\Order;
use App\Models\OrderItemPassenger;
use App\Models\TourPackage;
use App\Services\AsyncService;
use App\Services\EkajayaService;
use App\Services\GlobaltixService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with(['customer'])->where('order_type', Order::TYPE_ORDER);

        if ($request->q != '') {
            $query->where('order_code', 'like', "%{$request->q}%");
        }

        if ($request->agent != '') {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('id', 'like', "%$request->agent%")
                    ->where('is_agent', Customer::AGENT);
            });
        }

        return inertia('Order/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('Order/CreateForm', [
            '_date' => now()->format('m-d-Y')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_status' => 'nullable|numeric',
            'date' => 'required|date',
            'items' => 'required|array',
            'items.*.id' => 'required',
            'items.*.price' => 'required|numeric',
            'items.*.type' => 'required',
        ]);

        DB::beginTransaction();
        $total = 0;

        $customer = Customer::find($request->customer_id);
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $request->customer_id,
            'total_amount' => $total,
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
            'payment_channel' => 'Manual',
            'payment_status' => $request->payment_status
        ]);

        foreach ($request->items as $ritem) {
            $orderItem = null;
            if ($ritem['type'] == 'track') {
                $orderItem = FastboatTrack::find($ritem['id']);
            }

            if ($ritem['type'] == 'tour') {
                $orderItem = TourPackage::find($ritem['id']);
            }

            if ($ritem['type'] == 'car') {
                $orderItem = CarRental::find($ritem['id']);
            }

            $item = $order->items()->create([
                'entity_order' => $orderItem::class,
                'entity_id' => $orderItem->id,
                'description' => $orderItem->name,
                'amount' => $orderItem->price,
                'quantity' => $ritem['qty'],
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'item_addtional_info_json' => json_encode($orderItem),
            ]);

            if ($ritem['type'] == 'track') {
                if ($orderItem->data_source == EkajayaService::class) {
                    AsyncService::async(function () use ($item) {
                        EkajayaService::order($item);
                    });
                }

                if ($orderItem->data_source == GlobaltixService::class) {
                    AsyncService::async(function () use ($item) {
                        GlobaltixService::order($item);
                    });
                }

                $track = FastboatTrack::find($orderItem->id);
                FastboatTrack::updateTrackUsage($track, $request->date, $ritem['qty']);

                $item->passengers()->create([
                    'customer_id' => $customer->id,
                    'nation' => $customer->nation,
                    'national_id' => $customer->national_id,
                    'name' => $customer->name,
                    'type' => OrderItemPassenger::TYPE_PERSON,
                ]);
            }

            $total += $orderItem->price  * $ritem['qty'];
            info('total', [$total, $orderItem->price, $ritem['qty']]);
        }

        $order->update(['total_amount' => $total]);

        DB::commit();

        return redirect()->route('order.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function show(Order $order)
    {
        return inertia('Order/Detail', [
            'order' => $order->load(['customer', 'items.passengers', 'promos.promo']),
        ]);
    }

    public function edit(Order $order)
    {
        return inertia('Order/Form', [
            'order' => $order->load(['customer', 'items']),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'nullable',
            'description' => 'nullable|string',
        ]);

        if ($order->payment_status != $request->payment_status) {
            $order->fill([
                'payment_status' => $request->payment_status,
                'payment_type' => 'Manual|' . $order->payment_type,
            ]);
        }

        $order->description = $request->description;
        $order->save();

        return redirect()->route('order.index')
            ->with('message', ['type' => 'success', 'message' => 'Order has beed updated']);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Order has beed deleted']);
    }

    public function ticket_download(Order $order)
    {
        $item = $order->items()->first();

        $pdf = Pdf::loadView('pdf.ticket', ['item' => $item]);

        $pdf->setPaper([0, 0, 850, 350]);

        return $pdf->stream();
    }
}
