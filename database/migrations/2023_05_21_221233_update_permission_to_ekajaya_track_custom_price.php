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

        $permission = Permission::where('name', 'create-ekajaya-to-track')->exists();

        if (!$permission && Permission::count() != 0) {
            $permissions = [
                ['id' => Str::uuid(), 'label' => 'Create API Integration Track', 'name' => 'create-ekajaya-to-track'],
                ['id' => Str::uuid(), 'label' => 'Update API Integration Track', 'name' => 'update-ekajaya-to-track'],
                ['id' => Str::uuid(), 'label' => 'View API Integration Track', 'name' => 'view-ekajaya-to-track'],
                ['id' => Str::uuid(), 'label' => 'Delete API Integration Track', 'name' => 'delete-ekajaya-to-track'],
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
