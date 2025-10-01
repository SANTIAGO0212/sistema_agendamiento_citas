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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha');
            $table->time('hora');
            $table->boolean('estado')->default(1);
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_servicio')->constrained('servicios')->onDelete('cascade');
            $table->foreignId('id_especialista')->constrained('especialistas')->onDelete('cascade');
            $table->foreignId('id_sucursal')->constrained('sucursales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
