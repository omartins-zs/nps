<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    //
    protected $fillable = ['setor_id', 'nota', 'comentario'];

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }
}
