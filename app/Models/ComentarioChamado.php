<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioChamado extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment',
    ];

    /**
     * Relacionamento com o chamado
     */
    public function chamado()
    {
        return $this->belongsTo(Chamado::class, 'ticket_id');
    }

    /**
     * Relacionamento com o usuário (autor do comentário)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
