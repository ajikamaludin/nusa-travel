<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
                'payment_type' => 'Manual|'.$order->payment_type,
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
