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
        Schema::table('servicios', function (Blueprint $table) {
            $table->decimal('valor_inicial', 15,2);
            $table->boolean('descuento')->default(0);
            $table->decimal('valor_descuento')->nullable();
            $table->decimal('valor_total', 15,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn('valor_inicial');
            $table->dropColumn('descuento');
            $table->dropColumn('valor_descuento');
            $table->dropColumn('valor_total');
        });
    }
};
