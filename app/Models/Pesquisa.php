<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesquisa extends Model
{
    use HasFactory;

    protected $table = 'pesquisas';

    protected $fillable = [
        'titulo',
        'descricao',
        'departamento_id',
        'prazo',
    ];
}
