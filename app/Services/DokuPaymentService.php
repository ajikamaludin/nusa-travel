<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DokuPaymentService
{
    protected $url = 'https://api-sandbox.doku.com';

    protected $order;

    protected $clientId;

    protected $secretKey;

    private $payload = [];

    public function __construct(Order $order, $clientId, $secretKey)
    {
        $this->order = $order;
        $this->clientId = $clientId;
        $this->secretKey = $secretKey;

        if (app()->isProduction()) {
            $this->url = 'https://api.doku.com';
        }
    }

    public function getPaymentUrl()
    {
        $endpoint = '/checkout/v1/payment';
        $url = $this->url . $endpoint;
        $data = $this->generateBody();
        $header = $this->generateHeader($endpoint);

        $response = Http::acceptJson()
            ->withHeaders($header)
            ->post($url, $data);

        // debug
        info(DokuPaymentService::class, [
            'url' => $url,
            'header' => $header,
            'body' => $data,
            'response' => $response->json(),
            'raw' => $response,
        ]);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    public function getCreditCardPaymentUrl()
    {
        $endpoint = '/credit-card/v1/payment-page';
        $url = $this->url . $endpoint;
        $data = $this->generateBody();
        $header = $this->generateHeader($endpoint);

        $response = Http::acceptJson()
            ->withHeaders($header)
            ->post($url, $data);

        // debug
        info(DokuPaymentService::class, [
            'url' => $url,
            'header' => $header,
            'body' => $data,
            'response' => $response->json(),
            'raw' => $response,
        ]);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    public function getCreditCard3DSecureCheck()
    {
        $endpoint = '/credit-card/check-three-d-secure';
        $url = $this->url . $endpoint;
        $data = $this->generateBody();
        $header = $this->generateHeader($endpoint);

        $response = Http::acceptJson()
            ->withHeaders($header)
            ->post($url, $data);

        // debug
        info(DokuPaymentService::class, [
            'url' => $url,
            'header' => $header,
            'body' => $data,
            'response' => $response->json(),
            'raw' => $response,
        ]);

        if ($response->ok()) {
            return $response->json();
        }

        return null;
    }

    private function generateBody()
    {
        if ($this->payload != []) {
            return $this->payload;
        }
        $items = $this->order->items->map(function ($item) {
            return [
                'id' => $item->id,
                'price' => number_format($item->amount, 0, '.', ''),
                'quantity' => $item->quantity,
                'name' => $this->filterOnlyAllowedChar($item->item->order_detail),
                'sku' => 'SKU-' . $item->id,
                'category' => 'Travel Agent Product',
                'url' => route('home.index', ['locale' => 'en']),
                'image_url' => route('home.index', ['locale' => 'en']),
                'type' => 'Travel Agent Product',
            ];
        });

        if ($this->order->total_discount > 0) {
            $items->add([
                'id' => 'Discount',
                'price' => -number_format($this->order->total_discount, 0, '.', ''),
                'quantity' => 1,
                'name' => 'DISCOUNT',
                'sku' => 'SKU-DISCOUNT',
                'category' => 'Travel Agent Product',
                'url' => route('home.index', ['locale' => 'en']),
                'image_url' => route('home.index', ['locale' => 'en']),
                'type' => 'Travel Agent Product',
            ]);
        }

        $this->payload = [
            'order' => [
                'amount' => number_format($this->order->total_amount, 0, '.', ''),
                'invoice_number' => $this->order->order_code,
                'currency' => 'IDR',
                'callback_url' => route('customer.order', ['order' => $this->order]),
                // 'callback_url_cancel' => route('home.index', ['locale' => 'en']),
                // 'language' => 'EN',
                // 'auto_redirect' => true,
                // 'disable_retry_payment' => true,
                // 'line_items' => $items->toArray(),
            ],
            'payment' => [
                'payment_due_date' => 60, // in minute
            ],
            'customer' => [
                'id' => $this->order->customer->id,
                'name' => $this->filterOnlyAllowedChar($this->order->customer->name),
                //     // 'last_name' => 'Anggraeni',
                // 'phone' => '083840745543',
                'email' => $this->order->customer->email,
                'address' => $this->filterOnlyAllowedChar($this->order->customer->address),
                //     // 'postcode' => '120129',
                //     // 'state' => 'Jakarta',
                //     // 'city' => 'Jakarta Selatan',
                'country' => 'ID',
            ],
            // 'additional_info' => [
            //     'allow_tenor' => [0, 3, 6, 12],
            //     'close_redirect' => 'www.doku.com',
            //     'doku_wallet_notify_url' => 'https://dw-notify.free.beeceptor.com',
            // ],
        ];

        return $this->payload;
    }

    private function generateHeader($endpoint)
    {
        $requestId = Str::uuid()->toString();
        $requestDate = now()->toISOString();
        $requestDate = substr($requestDate, 0, 19) . 'Z';
        // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
        $requestBody = $this->generateBody();

        // Generate Digest
        $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

        // Prepare Signature Component
        $componentSignature = 'Client-Id:' . $this->clientId . "\n" .
            'Request-Id:' . $requestId . "\n" .
            'Request-Timestamp:' . $requestDate . "\n" .
            'Request-Target:' . $endpoint . "\n" .
            'Digest:' . $digestValue;

        // Calculate HMAC-SHA256 base64 from all the components above
        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $this->secretKey, true));

        return [
            'Client-Id' => $this->clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $requestDate,
            'Signature' => 'HMACSHA256=' . $signature,
        ];
    }

    private function filterOnlyAllowedChar($string)
    {
        $allowed_chars_pattern = '/[^a-zA-Z0-9.\-\/+,_=:\'@%"]/';
        $cleaned_string = preg_replace($allowed_chars_pattern, '', $string);

        return $cleaned_string;
    }
}
