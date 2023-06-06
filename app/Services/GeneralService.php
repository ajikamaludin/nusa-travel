<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Setting;

class GeneralService
{
    public static function getLocale($default = null)
    {
        $locale = session()->get('locale');
        if (in_array($locale, ['en', null, ''])) {
            $locale = $default;
        }

        return $locale;
    }

    public function getEnablePayment()
    {
        $setting = Setting::getInstance();
        $midtrans = $setting->setting->where('key', 'midtrans_enable')->value('value');
        $doku = $setting->setting->where('key', 'DOKU_ENABLE')->value('value');

        $payments = collect();
        if ($midtrans == 1) {
            $logo = $setting->setting->where('key', 'midtrans_logo')->first();
            $payments->add(['name' => Setting::PAYMENT_MIDTRANS, 'logo' => $logo->url]);
        }

        if ($doku == 1) {
            $logo = $setting->setting->where('key', 'DOKU_LOGO')->first();
            $payments->add(['name' => Setting::PAYMENT_DOKU, 'logo' => $logo->url]);

            // enable credit card direct payment page
            // $payments->add(['name' => Setting::PAYMENT_DOKU_CREDIT, 'logo' => 'CARD_CREDIT']);
        }

        $customer = auth('customer')->user();

        if ($customer != null) {
            if ($customer->is_agent == Customer::AGENT) {
                $balance = number_format($customer->deposite_balance, 0, ',', '.');
                $payments->add([
                    'name' => Setting::DEPOSITE_AGENT,
                    'logo' => null,
                    'display_name' => "Balance: $balance",
                ]);
            }
        }

        return $payments->toArray();
    }
}
