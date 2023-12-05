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
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 50);
            $table->unsignedTinyInteger('category_id')->comment('id de la categoria');
            $table->decimal('price_buy', 10, 2)->comment('precio de compra');
            $table->decimal('price_sale', 10, 2)->comment('precio de venta');
            $table->unsignedInteger('stock')->comment('stock actual');
            $table->tinyInteger('stock_min')->comment('stock minimo');
            $table->string('description', 1000)->nullable()->comment('descripcion del producto');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unique(['name', 'category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
