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
        Schema::create('acaos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->foreignId('user_id');
            $table->foreignId('area_conhecimento_id');
            $table->foreignId('area_tematica_id');
            $table->foreignId('area_extensao_id');
            $table->foreignId('tipo_acao_id');
            $table->string('atividade_relativa');
            $table->string('publico_alvo');
            $table->integer('vagas_total');
            $table->integer('vagas_externa');
            $table->string('local');
            $table->date('data_inicio');
            $table->date('data_encerramento');
            $table->time('hora_inicio');
            $table->time('hora_encerramento');
            $table->string('dias_semana');
            $table->time('carga_hr_semanal');
            $table->time('carga_hr_total');
            $table->string('periocidade');
            $table->string('modalidade');
            $table->string('turno');
            $table->string('duracao_aula');
            $table->string('criterio_aprovacao');
            $table->string('frequencia_minima');
            $table->string('media_aprovacao');
            $table->string('forma_avaliacao');
            $table->longText('requisitos');
            $table->longText('justificativa');
            $table->longText('objetivo_geral');
            $table->longText('objetivo_especifico');
            $table->longText('metodologia');
            $table->longText('bibliografia');
            $table->longText('outras_informacoes');
            $table->boolean('status');
            $table->date('data_inicio_inscricoes');
            $table->date('data_fim_inscricoes');
            $table->string('doacao');
            $table->string('tipo_doacao');
            $table->string('cota');
            $table->string('cota_servidor');
            $table->string('cota_discente');
            $table->string('cota_externo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acaos');
    }
};
