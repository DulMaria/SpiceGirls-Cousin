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
        Schema::create('curso', function (Blueprint $table) {
            $table->integer('ID_Curso')->primary();
            $table->integer('ID_Area')->index('fk_curso_area');
            $table->string('nombreCurso', 70);
            $table->string('descripcionCurso', 200);
            $table->char('estado', 1);
            $table->binary('imagen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso');
    }
};
