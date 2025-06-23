<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencia_estudiante', function (Blueprint $table) {
            // Cambiado a auto-incremental para mejor manejo
            $table->increments('ID_Asistencia');
            
            $table->date('fecha');
            
            // Usamos ENUM para limitar los valores posibles
            $table->enum('presente', ['P', 'A', 'L', 'F'])
                  ->comment('P=Presente, A=Atraso, L=Licencia, F=Falta');
            
            // Clave foránea con restricción
            $table->integer('ID_Historial');
            
            // Índices y restricciones
            $table->foreign('ID_Historial')
                  ->references('ID_Historial')
                  ->on('historial_academico')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            // Evita duplicados de asistencia para un estudiante en una fecha
            $table->unique(['fecha', 'ID_Historial']);
            
            // Timestamps para registro de creación/actualización
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencia_estudiante');
    }
};