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
        Schema::create('car_rental_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_code')->nullable();
            $table->string('car_name');
            $table->uuid('car_rental_id');
            $table->uuid('customer_id');
            $table->decimal('amount', 14, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('payment_status');
            $table->text('payment_response');
            $table->string('payment_channel');
            $table->string('payment_type');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->foreign('car_rental_id')->references('id')->on('car_rentals');
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
        Schema::dropIfExists('car_rental_orders');
    }
};
