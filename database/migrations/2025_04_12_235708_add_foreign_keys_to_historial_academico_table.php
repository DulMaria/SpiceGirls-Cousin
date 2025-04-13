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
        Schema::table('historial_academico', function (Blueprint $table) {
            $table->foreign(['ID_Apertura'], 'fk_historialacademico_apertura')->references(['ID_Apertura'])->on('apertura_modulo')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['codigoEstudiantil'], 'fk_historialacademico_estudiante')->references(['codigoEstudiantil'])->on('estudiante')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_academico', function (Blueprint $table) {
            $table->dropForeign('fk_historialacademico_apertura');
            $table->dropForeign('fk_historialacademico_estudiante');
        });
    }
};
