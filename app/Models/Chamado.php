<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chamado extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'usuario_criador_id',
        'usuario_responsavel_id',
        'status',
        'data_previsao',
        'data_finalizacao',
    ];

    /**
     * Relacionamento com o usuário criador do chamado
     */
    public function criador()
    {
        return $this->belongsTo(User::class, 'usuario_criador_id');
    }

    /**
     * Relacionamento com o usuário responsável pelo chamado
     */
    public function responsavel()
    {
        return $this->belongsTo(User::class, 'usuario_responsavel_id');
    }

    /**
     * Relacionamento com as tarefas do chamado
     */
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'chamado_id');
    }

    /**
     * Relacionamento com os comentários do chamado
     */
    public function comentarios()
    {
        return $this->hasMany(ComentarioChamado::class, 'ticket_id');
    }
}
