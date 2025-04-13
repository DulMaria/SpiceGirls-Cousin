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
        Schema::table('administrador', function (Blueprint $table) {
            $table->foreign(['ID_Usuario'], 'fk_admin_usuario')->references(['ID_Usuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrador', function (Blueprint $table) {
            $table->dropForeign('fk_admin_usuario');
        });
    }
};
