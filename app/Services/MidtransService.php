<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\FastboatOrder;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    protected $order;

    public function __construct(FastboatOrder $order, $serverKey)
    {
        Config::$serverKey = $serverKey;
        Config::$isProduction = app()->isProduction();
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->id,
                'gross_amount' => $this->order->amount * $this->order->quantity,
            ],
            'item_details' => [
                [
                    'id' => $this->order->id,
                    'price' => $this->order->amount,
                    'quantity' => $this->order->quantity,
                    'name' => $this->order->track_name,
                ],
            ],
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