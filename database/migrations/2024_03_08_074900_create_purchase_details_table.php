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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('material_id');
            $table->decimal('price', 5, 2);
            $table->decimal('quantity', 5, 1);
            $table->decimal('subtotal', 5, 2);
            $table->timestamps();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('material_id')->references('id')->on('raw_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
