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
        Schema::create('reportes', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('turno_reg');
            $table->integer('expediente_reg');
            $table->integer('turno_jefereg');
            $table->integer('expediente_jefereg');
            $table->integer('folio');
            $table->date('fecha');
            $table->string('linea');
            $table->integer('numero');
            $table->string('hora');
            $table->string('via');
            $table->string('estacion');
            $table->integer('tren');
            $table->string('carro');
            $table->text('falla');
            $table->string('tipo');
            $table->float('vueltas');
            $table->integer('expediente_c');
            $table->integer('expediente_reporta');
            $table->string('funcion_tren');
            $table->string('hora_funcion');
            $table->string('evacua');
            $table->integer('cve_motrices');
            $table->integer('retardo');
            $table->integer('duracion_incidente');
            $table->string('motrices_tren');
            $table->string('material');
            $table->string('usuario');
            $table->date('fec_mov');
            $table->string('hora_mov');
            $table->string('vigente');
            $table->string('atendido');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
