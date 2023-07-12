<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\OrderItemPassenger;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GlobaltixService
{
    const ACCESS_TOKEN = 'globaltix_accesstoken';

    const CACHE_TTL = 86400; // a day

    public static function auth()
    {
        $setting = Setting::getInstance();

        $enable = $setting->getValue('GLOBALTIX_ENABLE');
        if ($enable == 0) {
            throw new \Exception('Globaltix Setting Not Enabled', 1);

            return;
        }

        if (Cache::has(self::ACCESS_TOKEN)) {
            $token = Cache::get(self::ACCESS_TOKEN);
            Log::info(self::class, [self::ACCESS_TOKEN, $token]);

            return $token;
        }

        $host = $setting->getValue('GLOBALTIX_HOST');
        $username = $setting->getValue('GLOBALTIX_USERNAME');
        $password = $setting->getValue('GLOBALTIX_PASSWORD');
        $url = $host . '/auth/login';

        $response = Http::acceptJson()
            ->post($url, [
                'username' => $username,
                'password' => $password,
            ]);

        Log::info(self::class, [$url, [$response->status(), 'response' => $response->json()]]);

        if ($response->ok()) {
            $data = $response->json('data');
            $token = $data['token_type'] . ' ' . $data['access_token'];
            Cache::put(self::ACCESS_TOKEN, $token, $data['expires_in']);

            return $token;
        }

        if ($response->status() == 401) {
            throw new \Exception('Globaltix Auth Failed', 1);
        }

        throw new \Exception('Error Processing Request', 1);
    }

    private static function getApiProducts($host, $accessToken = '', $page = 1)
    {
        $key = self::class . '.products.' . $page;
        $url = $host . '/product/list';

        if (!Cache::has($key)) {
            $response = Http::acceptJson()
                ->withHeaders([
                    'Accept-Version' => '1.0',
                    'Authorization' => $accessToken,
                ])
                ->get($url, [
                    'countryId' => '2', // getAllListingCountry, 2: Indonesia
                    'cityIds' => 'all',
                    'categoryIds' => '9', // from getAllCategories, 9: transportations
                    'searchText' => '',
                    'page' => $page,
                    'lang' => 'en',
                ]);

            Log::info(self::class, [$url, $accessToken, [$response->status(), 'response' => $response->json()]]);

            $data = $response->json();
            Cache::put($key, $data, self::CACHE_TTL);
        } else {
            $data = Cache::get($key);
            Log::info(self::class, [$key, $data]);
        }

        $total = $data['size'];
        $p = $data['data'];

        foreach ($p as $product) {
            $products[] = [
                'id' => $product['id'],
                'name' => $product['name'],
            ];
        }

        return [
            'total' => $total,
            'products' => $products,
        ];
    }

    public static function getProducts($page = 1)
    {
        $setting = Setting::getInstance();
        $host = $setting->getValue('GLOBALTIX_HOST');

        $accessToken = self::auth();

        $products = [];

        $data = self::getApiProducts($host, $accessToken, $page);
        $total = $data['total'];
        $products = array_merge($products, $data['products']);

        while ($total != count($products)) {
            $page += 1;
            $data = self::getApiProducts($host, $accessToken, $page);
            $products = array_merge($products, $data['products']);
        }

        return $products;
    }

    public static function getOptions($productId)
    {
        $key = self::class . '.product/options.' . $productId;

        if (!Cache::has($key)) {
            $setting = Setting::getInstance();
            $host = $setting->getValue('GLOBALTIX_HOST');

            $accessToken = self::auth();

            $url = $host . '/product/options';
            $response = Http::acceptJson()
                ->withHeaders([
                    'Accept-Version' => '1.0',
                    'Authorization' => $accessToken,
                ])
                ->get($url, [
                    'id' => $productId,
                    'lang' => 'en',
                    'includeSR' => 1,
                ]);

            Log::info(self::class, [$url, $accessToken, [$response->status(), 'response' => $response->json()]]);

            $data = $response->json('data');
            Cache::put($key, $data, self::CACHE_TTL);
        } else {
            $data = Cache::get($key);
            Log::info(self::class, [$key, $data]);
        }

        $options = [];

        foreach ($data as $d) {
            $options[] = [
                'name' => $d['name'],
                'description' => $d['description'],
                'time_slots' => $d['timeSlot'],
                'questions' => $d['questions'],
                'ticket_type_id' => $d['ticketType'][0]['id'],
                'ticket_type_name' => $d['ticketType'][0]['name'],
                'ticket_type_price' => $d['ticketType'][0]['originalPrice'],
            ];
        }

        return $options;
    }

    public static function getCheckAvailability($ticketTypeId, $date, $timeslot = '00:00')
    {
        $setting = Setting::getInstance();
        $host = $setting->getValue('GLOBALTIX_HOST');

        $enabled = $setting->getValue('GLOBALTIX_ENABLE');
        if ($enabled == 0) {
            return [
                'id' => null,
                'available' => 0,
                'total' => 0,
            ];
        }

        $accessToken = self::auth();

        $url = $host . '/ticketType/checkEventAvailability';
        $response = Http::acceptJson()
            ->withHeaders([
                'Accept-Version' => '1.0',
                'Authorization' => $accessToken,
            ])
            ->get($url, [
                'id' => $ticketTypeId,
                'date' => $date,
            ]);

        Log::info(self::class, [
            $url,
            $accessToken,
            [
                'query_param' => [
                    'id' => $ticketTypeId,
                    'date' => $date,
                ],
                'status' => $response->status(),
                'response' => $response->json()
            ]
        ]);

        $data = $response->json('data');

        $avability = [
            'id' => null,
            'available' => 0,
            'total' => 0,
        ];

        if ($data != null) {
            foreach ($data as $time) {
                $check = strpos($time['time'], $timeslot);
                if ($check != false) {
                    $avability = $time;
                    break;
                }
            }
        }

        return [
            'id' => $avability['id'],
            'available' => $avability['available'],
            'total' => $avability['total'],
        ];
    }

    public static function order(OrderItem $item)
    {
        $setting = Setting::getInstance();
        $host = $setting->getValue('GLOBALTIX_HOST');

        $accessToken = self::auth();

        $questions = [];
        $order = $item->order;
        $quantity = $item->passengers()->where('type', OrderItemPassenger::TYPE_PERSON)->count();
        $track = $item->item;
        $ticket = json_decode($track->attribute_json);
        $event = self::getCheckAvailability($ticket->ticket_type->id, $item->date, $ticket->ticket_type->time_slot);

        if ($event['id'] == null) {
            $item->update(['item_addtional_info_json' => 'avability null when order']);

            return;
        }

        foreach ($ticket->ticket_type->questions as $question) {
            if (str($question->question)->contains('Name')) {
                $questions[] = [
                    'id' => $question->id,
                    'answer' => $order->customer->name,
                ];

                continue;
            }
            if (str($question->question)->contains('KTP')) {
                $questions[] = [
                    'id' => $question->id,
                    'answer' => $order->customer->national_id ?? ' - ',
                ];

                continue;
            }
            if (str($question->question)->contains('Nationality')) {
                $questions[] = [
                    'id' => $question->id,
                    'answer' => $order->customer->nation ?? ' - ',
                ];

                continue;
            }
            if (str($question->question)->contains('Age')) {
                $questions[] = [
                    'id' => $question->id,
                    'answer' => ' - ',
                ];

                continue;
            }
            if (str($question->question)->contains('Phone')) {
                $questions[] = [
                    'id' => $question->id,
                    'answer' => $order->customer->phone ?? ' - ',
                ];

                continue;
            }
        }

        $data = [
            // TODO: changes ticket type to each 1 pessenger quantity 1
            'ticketTypes' => [[
                'index' => 0,
                'id' => $ticket->ticket_type->id,
                'fromResellerId' => null,
                'quantity' => $quantity,
                'redeemStart' => null,
                'redeemEnd' => null,
                'visitDate' => $item->date,
                'event_id' => $event['id'],
                'questionList' => $questions,
            ]],
            'customerName' => $order->customer->name,
            'email' => $order->customer->email,
            'paymentMethod' => 'CREDIT',
            'newModel' => true,
        ];

        $url = $host . '/transaction/create';
        $response = Http::acceptJson()
            ->withHeaders([
                'Accept-Version' => '1.0',
                'Authorization' => $accessToken,
            ])
            ->post($url, $data);

        Log::info(self::class, [
            $url,
            $accessToken,
            [
                $response->status(),
                'data' => $data,
                'response' => $response->json(),
            ],
        ]);

        $item->update([
            'globaltix_response_json' => json_encode($response->json()),
        ]);
    }
}
