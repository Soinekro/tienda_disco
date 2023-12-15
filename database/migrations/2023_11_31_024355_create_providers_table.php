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
        Schema::create('providers', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->char('ruc', 11)->unique()->comment('ruc');
            $table->string('name', 150);
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('address', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
