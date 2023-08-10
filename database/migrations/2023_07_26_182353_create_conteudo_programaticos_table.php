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
        Schema::create('conteudo_programaticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acao_id');
            $table->string('ministrante');
            $table->string('cpf');
            $table->string('email');
            $table->mediumText('ementa');
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->time('carga_horaria');
            $table->integer('certificado_cod');
            $table->date('certificado_data');
            $table->boolean('certificado_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conteudo_programaticos');
    }
};
