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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('id del usuario');
            $table->foreignId('client_id')->constrained()->comment('id del cliente');
            $table->string('code', 50)->comment('codigo ticket');
            $table->unsignedInteger('total')->comment('total de la venta');
            $table->enum('status', [1, 0])->default(1);
            $table->unsignedTinyInteger('type_pay_id')->comment('pago de la compra');
            $table->foreign('type_pay_id')->references('id')->on('type_pays')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
