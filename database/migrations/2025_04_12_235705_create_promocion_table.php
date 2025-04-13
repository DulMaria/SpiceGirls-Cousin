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
        Schema::create('promocion', function (Blueprint $table) {
            $table->integer('ID_Promo')->primary();
            $table->decimal('descuento', 5);
            $table->string('descripcion', 100);
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->char('estado', 1);
            $table->char('tipo', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocion');
    }
};
