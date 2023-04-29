<?php

use App\Models\Page;
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
        $page = Page::where('title', 'feature-home')->exists();

        if (! $page) {
            $pages = [
                ['key' => 'home', 'title' => 'feature-home', 'file' => '/../seeders/pages/feature/home.txt'],
                ['key' => 'car-rental', 'title' => 'feature-car-rental', 'file' => '/../seeders/pages/feature/car-rental.txt'],
                ['key' => 'faq', 'title' => 'feature-faq', 'file' => '/../seeders/pages/feature/faq.txt'],
                ['key' => 'fastboat-ekajaya', 'title' => 'feature-fastboat-ekajaya', 'file' => '/../seeders/pages/feature/fastboat-ekajaya.txt'],
                ['key' => 'fastboat', 'title' => 'feature-fastboat', 'file' => '/../seeders/pages/feature/fastboat.txt'],
                ['key' => 'tour-package', 'title' => 'feature-tour-package', 'file' => '/../seeders/pages/feature/tour-package.txt'],
            ];

            foreach ($pages as $page) {
                Page::create([
                    'key' => $page['key'],
                    'title' => $page['title'],
                    'body' => file_get_contents(__DIR__.$page['file']),
                ]);
            }
        }

        if (! Schema::hasColumn('fastboat_tracks', 'attribute_json')) {
            Schema::table('fastboat_tracks', function (Blueprint $table) {
                $table->text('attribute_json')->nullable();
            });
        }

        if (! Schema::hasTable('unavailable_dates')) {
            Schema::create('unavailable_dates', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->date('close_date', 0)->nullable();

                $table->timestamps();
                $table->softDeletes();
                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();
            });
        }

        $permission = Permission::where('name', 'view-unavailable-date')->exists();

        if (! $permission) {
            $permissions = [
                ['id' => Str::uuid(), 'label' => 'View Unavailable Date', 'name' => 'view-unavailable-date'],
                ['id' => Str::uuid(), 'label' => 'Create Unavailable Date', 'name' => 'create-unavailable-date'],
                ['id' => Str::uuid(), 'label' => 'Update Unavailable Date', 'name' => 'update-unavailable-date'],
                ['id' => Str::uuid(), 'label' => 'Delete Unavailable Date', 'name' => 'delete-unavailable-date'],
            ];

            Permission::insert($permission);
        }

        $setting = Setting::where('key', 'GLOBALTIX_HOST')->exists();

        if (! $setting) {
            $settings = [
                ['id' => Str::uuid(), 'key' => 'GLOBALTIX_HOST', 'value' => 'https://uat-api.globaltix.com/api', 'type' => 'text', 'label' => 'GlobalTix Api Host'],
                ['id' => Str::uuid(), 'key' => 'GLOBALTIX_USERNAME', 'value' => 'business@nusa.travel', 'type' => 'text', 'label' => 'GlobalTix Username'],
                ['id' => Str::uuid(), 'key' => 'GLOBALTIX_PASSWORD', 'value' => '12345', 'type' => 'text', 'label' => 'GlobalTix Password'],
                ['id' => Str::uuid(), 'key' => 'GLOBALTIX_ENABLE', 'value' => '0', 'type' => 'text', 'label' => 'GlobalTix Integration Enable'],
            ];

            Setting::insert($settings);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unavailable_dates');
    }
};
