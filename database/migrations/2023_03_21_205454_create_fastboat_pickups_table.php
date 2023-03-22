<?php

use App\Models\Permission;
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
        Schema::create('fastboat_pickups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('source_id')->nullable();
            $table->uuid('car_rental_id')->nullable();
            $table->decimal('cost')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
        });

        $check = Permission::where('name', 'view-fastboat-pickup')->first();
        if ($check == null) {
            $permissions = [
                ['id' => Str::uuid(), 'label' => 'View Fastboat Pickup', 'name' => 'view-fastboat-pickup'],
                ['id' => Str::uuid(), 'label' => 'Create Fastboat Pickup', 'name' => 'create-fastboat-pickup'],
                ['id' => Str::uuid(), 'label' => 'Update Fastboat Pickup', 'name' => 'update-fastboat-pickup'],
                ['id' => Str::uuid(), 'label' => 'Delete Fastboat Pickup', 'name' => 'delete-fastboat-pickup'],
            ];

            Permission::insert($permissions);
        }

        $check = Setting::where('key', 'EKAJAYA_HOST')->first(); 
        if ($check == null)  {
            $settings = [
                ['id' => Str::uuid(), 'key' => 'EKAJAYA_HOST', 'value' => 'https://nusatravel.ajikamaludin.id', 'type' => 'text', 'label' => 'Ekajaya Api Host'],
                ['id' => Str::uuid(), 'key' => 'EKAJAYA_APIKEY', 'value' => 'abc-test', 'type' => 'text', 'label' => 'Ekajaya Api Key'],
                ['id' => Str::uuid(), 'key' => 'EKAJAYA_ENABLE', 'value' => '0', 'type' => 'text', 'label' => 'Ekajaya Integration Enable'],
            ];

            Setting::insert($settings);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fastboat_pickups');
    }
};
