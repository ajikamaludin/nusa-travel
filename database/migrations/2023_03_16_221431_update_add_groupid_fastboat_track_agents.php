<?php

use App\Models\Permission;
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
            $table->string('fastboat_track_agent_group_id')->nullable();
        });

        $check = Permission::where('name', 'view-price-agent')->exists();
        if (!$check && Permission::count() != 0) {
            $permissions = [
                ['id' => Str::uuid(), 'label' => 'Create Agent', 'name' => 'create-agent'],
                ['id' => Str::uuid(), 'label' => 'Update Agent', 'name' => 'update-agent'],
                ['id' => Str::uuid(), 'label' => 'View Agent', 'name' => 'view-agent'],
                ['id' => Str::uuid(), 'label' => 'Delete Agent', 'name' => 'delete-agent'],

                ['id' => Str::uuid(), 'label' => 'View Price Agent', 'name' => 'view-price-agent'],
                ['id' => Str::uuid(), 'label' => 'Create Price Agent', 'name' => 'create-price-agent'],
                ['id' => Str::uuid(), 'label' => 'Update Price Agent', 'name' => 'update-price-agent'],
                ['id' => Str::uuid(), 'label' => 'Delete Price Agent', 'name' => 'delete-price-agent'],
            ];

            Permission::insert($permissions);
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
