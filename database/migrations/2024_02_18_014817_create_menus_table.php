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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menuname');
            $table->string('description');
            $table->integer('quantity');
            $table->decimal('cost', 5, 2);
            $table->decimal('price', 5, 2);
            $table->string('status');
            $table->string('menu_type');
            $table->string('menuimage');
            $table->timestamps();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
