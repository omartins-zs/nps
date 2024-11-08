<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nps extends Model
{
    protected $table = 'notas';

    public static function getNps($month, $year)
    {
        // Filtrando as notas com base no mês e ano
        $result = DB::table('notas')
            ->whereMonth('DATA_RESPOSTA', $month)
            ->whereYear('DATA_RESPOSTA', $year)
            ->get();

        // Inicializando contadores
        $nps = (object) [
            'NOTAS' => 0,
            'PROMOTORES' => 0,
            'NEUTROS' => 0,
            'DETRATORES' => 0
        ];

        // Calculando NPS
        foreach ($result as $item) {
            $nps->NOTAS++;
            if ($item->NOTA >= 9) {
                $nps->PROMOTORES++;
            } elseif ($item->NOTA >= 7) {
                $nps->NEUTROS++;
            } else {
                $nps->DETRATORES++;
            }
        }

        $nps->RESULTADO = $nps->PROMOTORES - $nps->DETRATORES;
        $nps->PROMOTORES_PORCENTAGEM = ($nps->PROMOTORES / $nps->NOTAS) * 100;
        $nps->NEUTROS_PORCENTAGEM = ($nps->NEUTROS / $nps->NOTAS) * 100;
        $nps->DETRATORES_PORCENTAGEM = ($nps->DETRATORES / $nps->NOTAS) * 100;
        $nps->PORCENTAGEM = ($nps->RESULTADO / $nps->NOTAS) * 100;

        // Definindo a nota do NPS com base na porcentagem
        $nps->NPS = self::getNpsRating($nps->PORCENTAGEM);

        return $nps;
    }

    // Método auxiliar para definir nota, cor e ícone com base na porcentagem de NPS
    private static function getNpsRating($nps)
    {
        $nps = intval($nps);

        if ($nps > 75) {
            return ["NOTA" => "Excelente", "COR" => "green", "ICONE" => "smile"];
        } elseif ($nps >= 50 && $nps <= 74) {
            return ["NOTA" => "Muito Bom", "COR" => "blue", "ICONE" => "smile"];
        } elseif ($nps >= 0 && $nps < 50) {
            return ["NOTA" => "Razoável", "COR" => "yellow", "ICONE" => "meh"];
        } else {
            return ["NOTA" => "Ruim", "COR" => "red", "ICONE" => "frown"];
        }
    }
}
