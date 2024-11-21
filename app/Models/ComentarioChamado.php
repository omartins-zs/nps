<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioChamado extends Model
{
    use HasFactory;

    protected $fillable = [
        'chamado_id',
        'usuario_id',
        'comentario',
    ];

    /**
     * Relacionamento com o chamado
     */
    public function chamado()
    {
        return $this->belongsTo(Chamado::class, 'chamado_id');
    }

    /**
     * Relacionamento com o usuário (autor do comentário)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
