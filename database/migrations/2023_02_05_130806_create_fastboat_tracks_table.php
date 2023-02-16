<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fastboat_tracks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fastboat_source_id')->nullable();
            $table->uuid('fastboat_destination_id')->nullable();
            $table->decimal('price', 14, 2)->default(0);
            $table->integer('capacity')->default(0);
            $table->time('arrival_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->smallInteger('is_publish')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fastboat_tracks');
    }
};
