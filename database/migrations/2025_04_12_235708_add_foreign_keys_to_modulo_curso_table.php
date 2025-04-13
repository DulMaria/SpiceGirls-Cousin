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
        Schema::table('modulo_curso', function (Blueprint $table) {
            $table->foreign(['ID_Curso'], 'fk_modulocurso_curso')->references(['ID_Curso'])->on('curso')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modulo_curso', function (Blueprint $table) {
            $table->dropForeign('fk_modulocurso_curso');
        });
    }
};
