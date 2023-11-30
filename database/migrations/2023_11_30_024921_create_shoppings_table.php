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
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('fecha de la compra');
            $table->string('code', 50)->comment('factura');
            $table->unsignedInteger('total')->comment('total de la compra');
            $table->unsignedTinyInteger('type_pay_id')->comment('pago de la compra');
            $table->enum('status', [1,0])->default(1);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->comment('id del usuario');
            $table->unsignedInteger('provider_id')->comment('id del proveedor');
            $table->foreign('provider_id')->references('id')->on('providers')->cascadeOnDelete()->cascadeOnUpdate()->comment('id del proveedor');
            $table->foreign('type_pay_id')->references('id')->on('type_pays')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoppings');
    }
};
