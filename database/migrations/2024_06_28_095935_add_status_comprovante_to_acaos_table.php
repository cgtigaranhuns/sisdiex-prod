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
        Schema::table('acaos', function (Blueprint $table) {
            $table->boolean('status_comprovante')->nullable();
            $table->string('descricao_comprovante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acaos', function (Blueprint $table) {
            //
        });
    }
};
