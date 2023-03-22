<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fastboat_tracks', function ($table) {
            $table->string('data_source')->nullable();
        });
        Schema::table('fastboat_places', function ($table) {
            $table->string('data_source')->nullable();
        });
        Schema::table('order_item_passengers', function ($table) {
            $table->string('type')->nullable();
        });
        Schema::table('orders', function ($table) {
            $table->string('pickup')->nullable();
        });
        Schema::table('order_items', function ($table) {
            $table->string('pickup')->nullable();
            $table->uuid('pickup_id')->nullable();
        });
        Schema::table('posts', function ($table) {
            $table->uuid('original_id')->nullable();
            $table->string('lang')->nullable();
        });
        Schema::table('pages', function ($table) {
            $table->uuid('original_id')->nullable();
            $table->string('lang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
