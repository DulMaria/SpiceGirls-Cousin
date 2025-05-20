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
        Schema::table('inscripcion', function (Blueprint $table) {
            $table->foreign(['ID_Curso'], 'fk_inscripcion_curso')->references(['ID_Curso'])->on('curso')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['codigoEstudiantil'], 'fk_inscripcion_estudiante')->references(['codigoEstudiantil'])->on('estudiante')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripcion', function (Blueprint $table) {
            $table->dropForeign('fk_inscripcion_curso');
            $table->dropForeign('fk_inscripcion_estudiante');
        });
    }
};
