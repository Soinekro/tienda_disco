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
        Schema::create('shopping_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shopping_id')
                ->constrained()
                ->comment('id de la compra')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('product_id')
                ->comment('id del producto');
            $table->unsignedInteger('quantity')
                ->comment('cantidad comprada');
            $table->foreignId('product_unit_id')
                ->comment('unidades de compra')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('price_buy')
                ->comment('precio de compra');
            $table->double('total')
                ->comment('total de la compra');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_details');
    }
};
