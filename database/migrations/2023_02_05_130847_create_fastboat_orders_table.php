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
        Schema::create('fastboat_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_code')->nullable();
            $table->string('track_name');
            $table->uuid('fastboat_track_id');
            $table->uuid('customer_id');
            $table->decimal('amount', 14, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->date('date');
            $table->time('arrival_time');
            $table->time('departure_time');
            $table->string('payment_status');
            $table->text('payment_response');
            $table->string('payment_channel');
            $table->string('payment_type');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->foreign('fastboat_track_id')->references('id')->on('fastboat_tracks');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fastboat_orders');
    }
};
