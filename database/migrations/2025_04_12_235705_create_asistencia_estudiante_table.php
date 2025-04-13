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
        Schema::create('asistencia_estudiante', function (Blueprint $table) {
            $table->integer('ID_Asistencia')->primary();
            $table->date('fecha');
            $table->char('presente', 1);
            $table->integer('ID_Historial')->index('fk_asistencia_estudiante_historial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_estudiante');
    }
};
