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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orderid');
            $table->unsignedBigInteger('menuid');
            $table->string('note')->nullable();
            $table->integer('unit_quantity');
            $table->decimal('subtotal', 5, 2);
            $table->string('menu_status');
            $table->timestamps();
            $table->foreign('orderid')->references('id')->on('order')->onDelete('cascade');
            $table->foreign('menuid')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
