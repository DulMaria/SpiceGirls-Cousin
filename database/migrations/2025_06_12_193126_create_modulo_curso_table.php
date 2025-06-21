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
        Schema::create('modulo_curso', function (Blueprint $table) {
            $table->integer('ID_Modulo', true);
            $table->string('nombreModulo', 100);
            $table->string('descripcionModulo', 200);
            $table->char('estado', 1);
            $table->integer('orden');
            $table->integer('ID_Curso')->index('fk_modulocurso_curso');
            $table->time('fechaInicio');
            $table->time('fechaFin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulo_curso');
    }
};
