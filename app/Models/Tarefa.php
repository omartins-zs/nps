<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas_chamados';

    protected $fillable = [
        'chamado_id',
        'tipo_tarefa',
        'horas_gastas',
        'horas_previstas',
        'status',
        'descricao',
        'data_previsao',
        'data_finalizacao',
    ];

    /**
     * Relacionamento com o chamado
     */
    public function chamado()
    {
        return $this->belongsTo(Chamado::class, 'chamado_id');
    }

    /**
     * Relacionamento com o usuário (responsável pela tarefa)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
