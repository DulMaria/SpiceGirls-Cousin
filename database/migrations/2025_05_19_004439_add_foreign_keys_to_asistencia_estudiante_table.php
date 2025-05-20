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
        Schema::table('asistencia_estudiante', function (Blueprint $table) {
            $table->foreign(['ID_Historial'], 'fk_asistencia_estudiante_historial')->references(['ID_Historial'])->on('historial_academico')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencia_estudiante', function (Blueprint $table) {
            $table->dropForeign('fk_asistencia_estudiante_historial');
        });
    }
};
