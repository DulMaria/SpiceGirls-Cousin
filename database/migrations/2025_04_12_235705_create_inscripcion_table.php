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
        Schema::create('inscripcion', function (Blueprint $table) {
            $table->integer('ID_Inscripcion')->primary();
            $table->date('fechaInscrip');
            $table->integer('ID_Curso')->index('fk_inscripcion_curso');
            $table->string('codigoEstudiantil', 8)->index('fk_inscripcion_estudiante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion');
    }
};
