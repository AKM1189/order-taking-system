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
        Schema::create('raw_material_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menuid');
            $table->unsignedBigInteger('itemid');
            $table->decimal('quantity', 5, 1);
            $table->decimal('subtotal', 5, 2);
            $table->timestamps();
            $table->foreign('menuid')->references('id')->on('menus')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('itemid')->references('id')->on('raw_materials')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_details');
    }
};
