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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->string('invoice_no');
            $table->string('purchase_type');
            $table->string('description');
            $table->decimal('total', 5, 2);
            $table->decimal('paid_amount', 5, 2)->nullable();
            $table->decimal('balance', 5, 2);
            $table->string('payment_type');
            $table->unsignedBigInteger('supplier_id');
            $table->timestamps();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
