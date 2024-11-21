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
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->unsignedBigInteger('usuario_criador_id');
            $table->unsignedBigInteger('usuario_responsavel_id')->nullable();
            $table->enum('status', ['aberto', 'em_andamento', 'concluido'])->default('aberto');
            $table->date('data_previsao')->nullable();
            $table->date('data_finalizacao')->nullable();
            $table->timestamps();

            $table->foreign('usuario_criador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('usuario_responsavel_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
