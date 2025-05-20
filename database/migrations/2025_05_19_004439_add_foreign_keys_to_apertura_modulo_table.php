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
        Schema::table('apertura_modulo', function (Blueprint $table) {
            $table->foreign(['codigoDocente'], 'fk_aperturamodulo_docente')->references(['codigoDocente'])->on('docente')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ID_Modulo'], 'fk_aperturamodulo_modulo')->references(['ID_Modulo'])->on('modulo_curso')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apertura_modulo', function (Blueprint $table) {
            $table->dropForeign('fk_aperturamodulo_docente');
            $table->dropForeign('fk_aperturamodulo_modulo');
        });
    }
};
