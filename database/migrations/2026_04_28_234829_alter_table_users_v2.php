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
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono');
            $table->string('num_identificacion');
            $table->string('direccion');
            $table->foreignId('id_tipo_documento')->constrained('tipo_documentos')->onDelete('cascade');
            $table->foreignId('id_genero')->constrained('generos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telefono');
            $table->dropColumn('num_identificacion');
            $table->dropColumn('direccion');
            $table->dropForeign(['id_tipo_documento']);
            $table->dropColumn('id_tipo_documento');
            $table->dropForeign(['id_genero']);
            $table->dropColumn('id_genero');

        });
    }
};
