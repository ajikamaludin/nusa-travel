<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('payment_token')->change();
        });

        // setting payment
        $setting = Setting::where('key', 'midtrans_enable')->exists();
        if (!$setting && Setting::count() != 0) {
            $settings = [
                ['id' => Str::uuid(), 'key' => 'midtrans_enable', 'value' => '0', 'type' => 'text', 'label' => 'Midtrans Enable'],
                ['id' => Str::uuid(), 'key' => 'midtrans_logo', 'value' => 'images/midtrans_logo.png', 'type' => 'image', 'label' => 'Midtrans Logo'],

                ['id' => Str::uuid(), 'key' => 'DOKU_SECRET_KEY', 'value' => 'SK-Dtars5hbz5paIAMqk5zE', 'type' => 'text', 'label' => 'Doku Secret Key'],
                ['id' => Str::uuid(), 'key' => 'DOKU_CLIENT_ID', 'value' => 'BRN-0207-1683016182128', 'type' => 'text', 'label' => 'Doku Client ID'],
                ['id' => Str::uuid(), 'key' => 'DOKU_ENABLE', 'value' => '0', 'type' => 'text', 'label' => 'Doku Enable Payment'],
                ['id' => Str::uuid(), 'key' => 'DOKU_LOGO', 'value' => 'images/doku_logo.png', 'type' => 'image', 'label' => 'DOKU Logo'],
            ];

            Setting::insert($settings);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
