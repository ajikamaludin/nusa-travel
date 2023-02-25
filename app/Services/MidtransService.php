<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    protected $order;

    public function __construct(Order $order, $serverKey)
    {
        Config::$serverKey = $serverKey;
        Config::$isProduction = app()->isProduction();
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $items = $this->order->items->map(function ($item) {
            return [
                'id' => $item->id,
                'price' => $item->amount,
                'quantity' => $item->quantity,
                'name' => $item->item->order_detail,
            ];
        })->toArray();

        $params = [
            'transaction_details' => [
                'order_id' => $this->order->order_code,
                'gross_amount' => $this->order->total_amount,
            ],
            'item_details' => $items,
            'customer_details' => [
                'name' => $this->order->customer->name,
                'email' => $this->order->customer->email,
                'phone' => $this->order->customer->phone,
                'address' => $this->order->customer->address,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}