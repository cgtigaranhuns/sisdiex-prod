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
        Schema::create('inscricaos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acao_id');
            $table->string('inscricao_tipo');
            $table->foreignId('user_id');
            $table->foreignId('discente_id');
            $table->string('cpf');
            $table->string('nome');
            $table->string('telefone');
            $table->string('email');
            $table->string('instituicao_origem');
            $table->string('escolaridade');
            $table->date('data_nascimento');
            $table->string('naturalidade');
            $table->string('cor_raca');
            $table->string('inscricao_status');
            $table->string('aprovacao_status');
            $table->string('nota');
            $table->longText('obs');
            $table->string('motivo_reprovacao');
            $table->string('certificado_cod');
            $table->date('certificado_data');
            $table->string('responsavel_nome');
            $table->string('responsaval_cpf');
            $table->string('responsavel_grau');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricaos');
    }
};
