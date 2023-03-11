<?php

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
        Schema::create('promos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique()->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('is_active')->default(0);
            $table->string('cover_image')->nullable();

            // besaran potongan dalam persen atau nominal , hanya salah satu
            $table->integer('discount_type')->default(0);
            $table->integer('discount_amount')->nullable();

            // promo tersedia untuk tanggal start s/d end
            $table->date('available_start_date')->nullable();
            $table->date('available_end_date')->nullable();

            // promo di apply untuk order pada tanggal start s/d end
            $table->date('order_start_date')->nullable();
            $table->date('order_end_date')->nullable();

            // limit per hari untuk berapa user
            $table->integer('user_perday_limit')->default(0);
            // limit per hari untuk berapa transaksi
            $table->integer('order_perday_limit')->default(0);

            // syarat kapal / track
            $table->string('entity_type')->nullable();
            $table->uuid('entity_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
