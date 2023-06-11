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
        $setting = Setting::where('key', 'EKAJAYA_LOGO')->exists();
        if (!$setting && Setting::count() != 0) {
            $settings = [
                ['id' => Str::uuid(), 'key' => 'EKAJAYA_LOGO', 'value' => 'images/logo_ekajaya.png', 'type' => 'image', 'label' => 'Ekajaya Logo'],
                ['id' => Str::uuid(), 'key' => 'EKAJAYA_MARK', 'value' => 'By Integrated', 'type' => 'text', 'label' => 'Ekajaya Mark'],
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
