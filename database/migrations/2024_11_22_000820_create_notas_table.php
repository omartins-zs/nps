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
        Schema::create('notas', function (Blueprint $table) {
            $table->id(); // ID único da nota
            $table->unsignedBigInteger('usuario_id'); // Referência ao usuário
            $table->tinyInteger('nota')->unsigned(); // Nota entre 0 e 10
            $table->date('data_resposta'); // Data da resposta
            $table->timestamps(); // Criação e atualização

            // Relacionamento com a tabela de usuários
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
