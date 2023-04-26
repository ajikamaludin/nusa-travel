<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                $table->timestamp('close_date');

                $table->timestamps();
                $table->softDeletes();
                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();
            });
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
