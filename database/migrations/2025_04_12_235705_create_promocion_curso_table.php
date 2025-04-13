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
        Schema::create('promocion_curso', function (Blueprint $table) {
            $table->integer('ID_PromoCurso')->primary();
            $table->integer('ID_Curso')->index('fk_promocioncurso_curso');
            $table->integer('ID_Promo')->index('fk_promocioncurso_promocion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocion_curso');
    }
};
