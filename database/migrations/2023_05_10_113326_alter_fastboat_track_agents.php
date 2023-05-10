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
        Schema::table('fastboat_track_agents', function (Blueprint $table) {
            $table->string('fastboat_track_agent_group_id')->nullable()->change();
            $table->string('data_source')->nullable();
        });

        $settings = [
            ['id' => Str::uuid(), 'key' => 'GLOBALTIX_LOGO', 'value' => 'images/logo_ekajaya.png', 'type' => 'image', 'label' => 'GlobalTix Logo'],
            ['id' => Str::uuid(), 'key' => 'G_DEEPL_AUTHKEY', 'value' => '8d17f9dd-0b69-f305-0d1e-ec73aee8269c', 'type' => 'text', 'label' => 'Deepl Translation Api Key'],
        ];

        $check = Setting::where('key', 'GLOBALTIX_LOGO')->exists();

        if ($check && Setting::count() != 0) {
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
