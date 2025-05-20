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
        Schema::create('pago', function (Blueprint $table) {
            $table->integer('ID_Pago')->primary();
            $table->string('metodoPago', 20);
            $table->char('estadoPago', 1);
            $table->date('fechaPago');
            $table->integer('ID_Historial')->index('fk_pago_historial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
