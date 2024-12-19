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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('type_id');
            $table->date('orderdate');
            $table->time('ordertime');
            $table->decimal('subtotal', 5, 2);
            $table->decimal('grandtotal', 5, 2);
            $table->decimal('discount', 5, 2)->default('0');
            $table->decimal('tax', 5, 2)->default('2');
            $table->string('ordernote')->nullable();
            $table->string('orderstatus');
            $table->string('payment_type')->nullable();
            $table->decimal('paid_amount')->nullable();
            $table->decimal('change')->nullable();
            $table->string('order_token')->nullable();
            $table->timestamps();
            $table->foreign('table_id')->references('id')->on('tables');
            $table->foreign('staff_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('order_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
