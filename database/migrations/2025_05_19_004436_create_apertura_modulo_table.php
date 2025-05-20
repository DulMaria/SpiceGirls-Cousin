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
        Schema::create('apertura_modulo', function (Blueprint $table) {
            $table->integer('ID_Apertura')->primary();
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->char('estado', 1);
            $table->integer('ID_Modulo')->index('fk_aperturamodulo_modulo');
            $table->string('codigoDocente', 8)->index('fk_aperturamodulo_docente');
            $table->decimal('CostoModulo', 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_modulo');
    }
};
