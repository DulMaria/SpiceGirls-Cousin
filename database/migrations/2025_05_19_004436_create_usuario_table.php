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
        Schema::create('usuario', function (Blueprint $table) {
            $table->integer('ID_Usuario', true);
            $table->integer('ID_Rol')->index('fk_usuario_rol');
            $table->string('nombre', 30);
            $table->string('apellidoPaterno', 30)->nullable();
            $table->string('apellidoMaterno', 30)->nullable();
            $table->string('telefono', 8);
            $table->string('direccion', 150);
            $table->date('fechaNacimiento');
            $table->string('email', 50);
            $table->string('ci', 11);
            $table->string('contrasenia', 500);
            $table->char('estado', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
