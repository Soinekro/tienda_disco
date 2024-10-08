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
            $table->foreignId('client_id')
            ->nullable()
            ->constrained()->comment('id del cliente');
            $table->char('serie', 4)->comment('codigo ticket');
            $table->unsignedInteger('correlative')
                ->comment('correlativo de la venta');
            $table->unsignedInteger('total')->comment('total de la venta');
            $table->enum('status', [
                '1',
                '0',
                '2'
            ])
            ->default('1');
            $table->timestamps();
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
