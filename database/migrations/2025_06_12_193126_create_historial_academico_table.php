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
        Schema::create('historial_academico', function (Blueprint $table) {
            $table->integer('ID_Historial', true);
            $table->char('estado', 1);
            $table->integer('ID_Apertura')->index('fk_historialacademico_apertura');
            $table->string('codigoEstudiantil', 8)->index('fk_historialacademico_estudiante');
            $table->date('fechaRegistro');
            $table->integer('participacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_academico');
    }
};
