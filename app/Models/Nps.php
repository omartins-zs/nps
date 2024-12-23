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
            ->whereMonth('data_resposta', $month)
            ->whereYear('data_resposta', $year)
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
            if ($item->nota >= 9) {
                $nps->PROMOTORES++;
            } elseif ($item->nota >= 7) {
                $nps->NEUTROS++;
            } else {
                $nps->DETRATORES++;
            }
        }

        if ($nps->NOTAS > 0) {
            // Cálculo do NPS e porcentagens
            $nps->RESULTADO = $nps->PROMOTORES - $nps->DETRATORES;
            $nps->PROMOTORES_PORCENTAGEM = round(($nps->PROMOTORES / $nps->NOTAS) * 100, 2);
            $nps->NEUTROS_PORCENTAGEM = round(($nps->NEUTROS / $nps->NOTAS) * 100, 2);
            $nps->DETRATORES_PORCENTAGEM = round(($nps->DETRATORES / $nps->NOTAS) * 100, 2);
            $nps->PORCENTAGEM = round(($nps->RESULTADO / $nps->NOTAS) * 100, 2);
        } else {
            // Evitar divisão por zero
            $nps->RESULTADO = 0;
            $nps->PROMOTORES_PORCENTAGEM = 0;
            $nps->NEUTROS_PORCENTAGEM = 0;
            $nps->DETRATORES_PORCENTAGEM = 0;
            $nps->PORCENTAGEM = 0;
        }

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
    public static function relatorioIndicadores($selectedMonth = null, $selectedYear = null, $status = null, $detalhado = null)
    {
        // Filtro de data e status
        $filtroData = isset($detalhado) && !is_null($detalhado)
            ? "YEAR(c.data_previsao) = $selectedYear"
            : "MONTH(c.data_previsao) = $selectedMonth AND YEAR(c.data_previsao) = $selectedYear";

        $filtroStatus = !is_null($status) ? "AND c.status = '$status'" : "";

        // Consulta SQL ajustada
        $sql_avaliacoes = "
            SELECT
                c.id,
                c.data_previsao,
                EXTRACT(MONTH FROM c.data_previsao) AS mes,
                c.status
            FROM chamados c
            WHERE $filtroData $filtroStatus
            ORDER BY c.data_previsao
        ";

        $avaliacoes = DB::select($sql_avaliacoes);

        // Inicializando contadores
        $meses_do_ano = Meses_Do_Ano(); // Função auxiliar para obter os nomes dos meses
        $notas = [];
        $media_anual = ['RUIM' => 0, 'REGULAR' => 0, 'BOM' => 0, 'OTIMO' => 0];
        $total_mensal = array_fill_keys(array_values($meses_do_ano), 0);

        foreach ($avaliacoes as $av) {
            $mes = Nome_Do_Mes($av->mes); // Função auxiliar para mapear o mês ao nome
            $nota = $av->status;

            // Classificar os status
            $tipo = match ($nota) {
                'concluido' => 'OTIMO',
                'em_andamento' => 'BOM',
                'aberto' => 'REGULAR',
                default => 'RUIM'
            };

            $notas[$mes][$tipo] = ($notas[$mes][$tipo] ?? 0) + 1;
            $total_mensal[$mes]++;
        }

        // Calculando porcentagens e média anual
        $meses_validos = 0;
        foreach ($notas as $mes => $tipos) {
            foreach ($tipos as $tipo => $valor) {
                $porcentagem = $total_mensal[$mes] > 0 ? ($valor * 100 / $total_mensal[$mes]) : 0;
                $notas[$mes][$tipo] = number_format($porcentagem, 2, '.', '');
                $media_anual[$tipo] += $porcentagem;
            }
            $meses_validos++;
        }

        foreach ($media_anual as $tipo => &$total) {
            $total = $meses_validos > 0 ? number_format($total / $meses_validos, 2, ',', '') : '0,00';
        }

        return response()->json([
            'notas' => $notas,
            'media_anual' => $media_anual,
            'total_mensal' => $total_mensal
        ]);
    }


    public static function getQuantidadesMensal($selectedMonth = null, $selectedYear = null, $detalhado = null)
    {
        // Definindo os filtros de data
        $filtroData = isset($detalhado) ?
            "YEAR(data_finalizacao) = $selectedYear" :
            "MONTH(data_finalizacao) = $selectedMonth AND YEAR(data_finalizacao) = $selectedYear";

        $filtroData2 = isset($detalhado) ?
            "YEAR(data_previsao) = $selectedYear" :
            "MONTH(data_previsao) = $selectedMonth AND YEAR(data_previsao) = $selectedYear";

        // Query de chamados concluídos e cancelados
        $query = DB::table('cal')
            ->selectRaw('
                YEAR(data_finalizacao) AS ano,
                MONTH(data_finalizacao) AS mes,
                status,
                COUNT(*) AS total_mensal
            ')
            ->whereRaw($filtroData)
            ->whereIn('status', ['concluido', 'cancelado'])
            ->whereNotNull('data_finalizacao')
            ->groupByRaw('YEAR(data_finalizacao), MONTH(data_finalizacao), status')
            ->get();

        // Query de chamados abertos no mês
        $query2 = DB::table('cal')
            ->selectRaw('
                YEAR(data_previsao) AS ano,
                MONTH(data_previsao) AS mes,
                "aberto" AS status,
                COUNT(*) AS total_mensal
            ')
            ->whereRaw($filtroData2)
            ->groupByRaw('YEAR(data_previsao), MONTH(data_previsao)')
            ->get();

        // Mesclar os resultados das queries
        $resultadoBanco = $query->merge($query2);

        $totalConcluido = 0;
        $statusChamados = [];

        // Processamento dos resultados
        foreach ($resultadoBanco as $status) {
            if (in_array($status->status, ['concluido'])) {
                $totalConcluido += $status->total_mensal;
                $statusChamados['CONCLUÍDO'] = $totalConcluido;
            } elseif ($status->status === 'cancelado') {
                $statusChamados['CANCELADO'] = $status->total_mensal;
            } else {
                $statusChamados[strtoupper($status->status)] = $status->total_mensal;
            }
        }

        // Cálculos dos totais e percentuais
        $totalGeral = ($statusChamados['CONCLUÍDO'] ?? 0) + ($statusChamados['CANCELADO'] ?? 0);
        $statusChamados['total_chamados'] = $totalGeral;
        $statusChamados['PERCENTUAL_CONCLUIDO'] = $totalGeral > 0
            ? round(($statusChamados['CONCLUÍDO'] ?? 0) / $totalGeral * 100, 2)
            : 0;
        $statusChamados['PERCENTUAL_CANCELADO'] = $totalGeral > 0
            ? round(($statusChamados['CANCELADO'] ?? 0) / $totalGeral * 100, 2)
            : 0;

        // Retorna resultado detalhado ou resumido
        return is_null($detalhado) ? $statusChamados : $resultadoBanco;
    }

    // Função para obter a média de chamados
    public static function getMediaConclusaoChamados($selectedMonth = null, $selectedYear = null, $detalhado = null)
    {
        // Definindo o filtro de data
        $filtro_data = (isset($detalhado) && !is_null($detalhado))
            ? "YEAR(CHADATAFINAL) = " . $selectedYear
            : "MONTH(CHADATAFINAL) = " . $selectedMonth . " AND YEAR(CHADATAFINAL) = " . $selectedYear;

        // Query para pegar as médias de chamados
        $query = DB::connection('cal')->select("
SELECT
    ano,
    mes,
    MAX(diferenca_subquery.CHACODIGO) AS CHACODIGO,
    AVG(diferenca_dias) AS media_dias,
    COUNT(*) AS total_registros,
    SUM(CASE WHEN diferenca_dias > 3 THEN 1 ELSE 0 END) AS qtd_maior_que_tres,
    SUM(CASE WHEN diferenca_dias <= 3 THEN 1 ELSE 0 END) AS qtd_menor_igual_tres,
    (SUM(CASE WHEN diferenca_dias > 3 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS percentagem_maior_que_tres,
    (SUM(CASE WHEN diferenca_dias <= 3 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS percentagem_menor_igual_tres,
    GROUP_CONCAT(CASE WHEN diferenca_dias > 3 THEN CONCAT(diferenca_subquery.CHACODIGO, ':', diferenca_subquery.SETDESCRICAO, ':', diferenca_subquery.diferenca_dias) ELSE NULL END) AS CHAMADOS_MAIOR_QUE_TRES
FROM
    (SELECT
        I.CHACODIGO,
        I.CHADATA,
        MAX(I.CHADATAFINAL) AS CHADATAFINAL,
        DATEDIFF(MAX(I.CHADATAFINAL), I.CHADATA) - (2 * (FLOOR((DATEDIFF(MAX(I.CHADATAFINAL), I.CHADATA) + DAYOFWEEK(I.CHADATA) - 1) / 7))) AS diferenca_dias,
        YEAR(MAX(I.CHADATAFINAL)) AS ano,
        MONTH(MAX(I.CHADATAFINAL)) AS mes,
        I.SETCODIGO,
        S.SETDESCRICAO
    FROM
        inchamado I
        LEFT JOIN inchaprevisao IP ON I.CHACODIGO = IP.CHACODIGO
        LEFT JOIN insetor S ON (S.SETCODIGO = I.SETCODIGO)
    WHERE
        IP.CHPTIPO IN (2, 4)
        AND I.STACODIGO NOT IN (4, 6)
        AND DAYOFWEEK(I.CHADATAFINAL) BETWEEN 2 AND 6
        AND $filtro_data
    GROUP BY I.CHACODIGO, I.CHADATA, I.SETCODIGO, S.SETDESCRICAO
    ) AS diferenca_subquery
GROUP BY ano, mes
ORDER BY ano, mes
");

        // Contagem por setor e ajustes nos dados
        $contagemPorSetor = [];

        foreach ($query as $item) {
            $item->percentagem_maior_que_tres = number_format($item->percentagem_maior_que_tres, 2, '.', '');
            $item->percentagem_menor_igual_tres = number_format($item->percentagem_menor_igual_tres, 2, '.', '');

            // Transforma a string CHAMADOS_MAIOR_QUE_TRES em um array
            $item->CHAMADOS_MAIOR_QUE_TRES = explode(',', $item->CHAMADOS_MAIOR_QUE_TRES);

            // Loop pelos chamados para contar por setor
            foreach ($item->CHAMADOS_MAIOR_QUE_TRES as $chamado) {
                list($chacodigo, $setdescricao) = explode(':', $chamado);

                // Se o setor já estiver no array, incrementa a contagem, senão, inicializa com 1
                if (isset($contagemPorSetor[$setdescricao])) {
                    $contagemPorSetor[$setdescricao]++;
                } else {
                    $contagemPorSetor[$setdescricao] = 1;
                }
            }
        }

        // Adiciona a contagem por setor ao resultado
        if (count($query) > 0) {
            $query[0]->contagemPorSetor = $contagemPorSetor;
        }

        return $query;
    }

    public static function getChamadosCancelados($selectedMonth = null, $selectedYear = null, $detalhado = null)
    {
        // Define o filtro de data com base nos parâmetros passados
        $filtroData = $detalhado
            ? "YEAR(C.CHADATAFINAL) = " . intval($selectedYear)
            : "MONTH(C.CHADATAFINAL) = " . intval($selectedMonth) . " AND YEAR(C.CHADATAFINAL) = " . intval($selectedYear);

        // Query para buscar chamados cancelados e concluídos
        $query = DB::connection('cal')->select("
SELECT
    YEAR(C.CHADATAFINAL) AS ANO,
    MONTH(C.CHADATAFINAL) AS MES,
    C.STACODIGO,
    S.STADESCRICAO,
    C.CHACODIGO,
    COUNT(*) AS TOTAL_MENSAL
FROM
    INCHAMADO C
INNER JOIN inchastatus S ON S.STACODIGO = C.STACODIGO
WHERE $filtroData
    AND C.STACODIGO IN (3, 4, 6, 8)
    AND C.CHADATAFINAL IS NOT NULL
GROUP BY
    YEAR(C.CHADATAFINAL),
    MONTH(C.CHADATAFINAL),
    C.STACODIGO,
    S.STADESCRICAO,
    C.CHACODIGO
");

        // Query para buscar chamados abertos no mês
        $query2 = DB::connection('cal')->select("
SELECT
    YEAR(C.CHADATA) AS ANO,
    MONTH(C.CHADATA) AS MES,
    99 AS STACODIGO,
    'ABERTOS NO MES' AS STADESCRICAO,
    COUNT(*) AS TOTAL_MENSAL
FROM
    INCHAMADO C
WHERE $filtroData
GROUP BY
    YEAR(C.CHADATA),
    MONTH(C.CHADATA)
");

        // Combina os resultados das duas consultas
        $resultadoBanco = collect($query); // Converte para coleção para manipulação
        $resultadoBanco2 = collect($query2); // Converte para coleção para manipulação

        // Mescla os resultados das duas consultas
        $resultadoCombinado = $resultadoBanco->merge($resultadoBanco2);

        // Filtra os chamados cancelados (STACODIGO = 4)
        $codigosCancelados = $resultadoCombinado->filter(function ($status) {
            return $status->STACODIGO == 4;  // STACODIGO 4 representa os cancelados
        })->pluck('CHACODIGO')->toArray();

        // Retorna os chamados cancelados
        return [
            'CHAMADOS_CANCELADOS' => $codigosCancelados
        ];
    }

    public static function compararChamados($month1, $year1, $month2, $year2)
    {
        // Consulta para o primeiro mês e ano
        $filtroData1 = "MONTH(CHADATAFINAL) = $month1 AND YEAR(CHADATAFINAL) = $year1";
        $filtroDataAbertos1 = "MONTH(CHADATA) = $month1 AND YEAR(CHADATA) = $year1";

        $query1Concluidos = DB::connection('cal')->select("
        SELECT
            YEAR(C.CHADATAFINAL) AS ANO,
            MONTH(C.CHADATAFINAL) AS MES,
            C.STACODIGO,
            S.STADESCRICAO,
            COUNT(*) AS TOTAL_MENSAL
        FROM INCHAMADO C
        INNER JOIN inchastatus S ON S.STACODIGO = C.STACODIGO
        WHERE $filtroData1
            AND C.STACODIGO IN (3, 4, 8)
            AND C.CHADATAFINAL IS NOT NULL
        GROUP BY YEAR(C.CHADATAFINAL), MONTH(C.CHADATAFINAL), C.STACODIGO, S.STADESCRICAO
    ");

        $query1Abertos = DB::connection('cal')->select("
        SELECT
            YEAR(C.CHADATA) AS ANO,
            MONTH(C.CHADATA) AS MES,
            99 AS STACODIGO,
            'ABERTOS NO MES' AS STADESCRICAO,
            COUNT(*) AS TOTAL_MENSAL
        FROM INCHAMADO C
        WHERE $filtroDataAbertos1
        GROUP BY YEAR(C.CHADATA), MONTH(C.CHADATA)
    ");

        // Consulta para o segundo mês e ano
        $filtroData2 = "MONTH(CHADATAFINAL) = $month2 AND YEAR(CHADATAFINAL) = $year2";
        $filtroDataAbertos2 = "MONTH(CHADATA) = $month2 AND YEAR(CHADATA) = $year2";

        $query2Concluidos = DB::connection('cal')->select("
        SELECT
            YEAR(C.CHADATAFINAL) AS ANO,
            MONTH(C.CHADATAFINAL) AS MES,
            C.STACODIGO,
            S.STADESCRICAO,
            COUNT(*) AS TOTAL_MENSAL
        FROM INCHAMADO C
        INNER JOIN inchastatus S ON S.STACODIGO = C.STACODIGO
        WHERE $filtroData2
            AND C.STACODIGO IN (3, 4, 8)
            AND C.CHADATAFINAL IS NOT NULL
        GROUP BY YEAR(C.CHADATAFINAL), MONTH(C.CHADATAFINAL), C.STACODIGO, S.STADESCRICAO
    ");

        $query2Abertos = DB::connection('cal')->select("
        SELECT
            YEAR(C.CHADATA) AS ANO,
            MONTH(C.CHADATA) AS MES,
            99 AS STACODIGO,
            'ABERTOS NO MES' AS STADESCRICAO,
            COUNT(*) AS TOTAL_MENSAL
        FROM INCHAMADO C
        WHERE $filtroDataAbertos2
        GROUP BY YEAR(C.CHADATA), MONTH(C.CHADATA)
    ");

        // Processamento dos resultados para o primeiro conjunto de mês e ano
        $resultado1 = array_merge($query1Concluidos, $query1Abertos);
        $statusChamados1 = [
            'CONCLUIDO' => 0,
            'ABERTOS' => 0
        ];

        foreach ($resultado1 as $status) {
            if (in_array($status->STACODIGO, [3, 8])) {
                $statusChamados1['CONCLUIDO'] += $status->TOTAL_MENSAL;
            } elseif ($status->STACODIGO == 99) {
                $statusChamados1['ABERTOS'] = $status->TOTAL_MENSAL;
            }
        }

        // Processamento dos resultados para o segundo conjunto de mês e ano
        $resultado2 = array_merge($query2Concluidos, $query2Abertos);
        $statusChamados2 = [
            'CONCLUIDO' => 0,
            'ABERTOS' => 0
        ];

        foreach ($resultado2 as $status) {
            if (in_array($status->STACODIGO, [3, 8])) {
                $statusChamados2['CONCLUIDO'] += $status->TOTAL_MENSAL;
            } elseif ($status->STACODIGO == 99) {
                $statusChamados2['ABERTOS'] = $status->TOTAL_MENSAL;
            }
        }

        // Retorna os dados de ambos os meses para exibição nos gráficos
        return [
            'mes1' => [
                'mes' => $month1,
                'ano' => $year1,
                'dados' => $statusChamados1
            ],
            'mes2' => [
                'mes' => $month2,
                'ano' => $year2,
                'dados' => $statusChamados2
            ]
        ];
    }
}
