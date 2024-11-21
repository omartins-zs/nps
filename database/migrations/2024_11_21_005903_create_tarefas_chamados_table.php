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
        Schema::create('tarefas_chamados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chamado_id');
            $table->string('descricao');
            $table->enum('tipo_tarefa', ['atendimento', 'melhoria', 'novo projeto', 'manutencao']);
            $table->integer('horas_previstas')->nullable();
            $table->integer('horas_gastas')->nullable();
            $table->date('data_previsao')->nullable();
            $table->date('data_finalizacao')->nullable();  // Verifique se essa linha está presente
            $table->enum('status', ['aberta', 'em andamento', 'concluida']);
            $table->timestamps();

            $table->foreign('chamado_id')->references('id')->on('chamados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas_chamados');
    }
};
