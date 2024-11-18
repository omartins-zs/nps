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
        $result = DB::connection('nps')->table('notas')
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
    public static function relatorioIndicadores($selectedMonth = null, $selectedYear = null, $indicador = null, $detalhado = null)
    {
        // Configurando os filtros de data e indicador em formato SQL
        $filtroData = isset($detalhado) && !is_null($detalhado)
            ? "YEAR(C.AVADATA) = $selectedYear"
            : "MONTH(C.AVADATA) = $selectedMonth AND YEAR(C.AVADATA) = $selectedYear";
        $filtroIndicador = !is_null($indicador) ? "AND A.AVACODIGO = $indicador" : "";

        // Construindo a consulta SQL manualmente
        $sql_avaliacoes = "SELECT C.CHACODIGO, C.AVADATA, EXTRACT(MONTH FROM C.AVADATA) AS MES,
                      A.AVOCODIGO AS NOTA, A.AVACODIGO
                   FROM INCHAMADO C
                   INNER JOIN INCHAAVALIACAO A ON C.CHACODIGO = A.CHACODIGO
                   INNER JOIN INSUBDEPARTAMENTO S ON S.SDPCODIGO = C.SDPCODIGO
                   WHERE $filtroData $filtroIndicador
                   ORDER BY C.AVADATA";

        // Executando a consulta
        $avaliacoes = DB::connection('cal')->select($sql_avaliacoes);

        // Inicializando variáveis
        $notas = [];
        $total_mensal = [];
        $meses_do_ano = Meses_Do_Ano();  // Função helper para obter os meses do ano
        $total_chamados = 0;

        // Inicializando contadores de notas e total mensal
        foreach ($meses_do_ano as $m => $v) {
            $notas[$v] = [
                'RUIM' => 0,
                'REGULAR' => 0,
                'BOM' => 0,
                'OTIMO' => 0
            ];
            $total_mensal[Nome_Do_Mes($m)] = 0;
        }

        // Iteração sobre as avaliações para classificar notas e calcular totais
        foreach ($avaliacoes as $av) {
            $nota = $av->NOTA;
            $mes = Nome_Do_Mes($av->MES);

            // Excluir meses que têm conteúdo para cálculo de média anual
            $excluir_mes = str_pad($av->MES, 2, "0", STR_PAD_LEFT);
            unset($meses_do_ano[$excluir_mes]);

            // Classificação das notas
            switch ($nota) {
                case 1:
                case 5:
                case 9:
                    $notas[$mes]['OTIMO']++;
                    break;

                case 2:
                case 6:
                case 10:
                    $notas[$mes]['BOM']++;
                    break;

                case 4:
                case 7:
                case 11:
                    $notas[$mes]['REGULAR']++;
                    break;

                case 3:
                case 8:
                case 12:
                    $notas[$mes]['RUIM']++;
                    break;
            }

            $total_mensal[$mes]++;
            $total_chamados++;
        }

        // Calculando porcentagens
        $media_anual = [
            'OTIMO' => 0,
            'BOM' => 0,
            'REGULAR' => 0,
            'RUIM' => 0
        ];
        foreach ($notas as $n => $v) {
            foreach ($v as $tipo => $t) {
                if ($total_mensal[$n] > 0) {
                    $porcentagem = ($t * 100) / $total_mensal[$n];
                    $notas[$n][$tipo] = number_format($porcentagem, 2, '.', '');

                    // Acumulando para média anual
                    $media_anual[$tipo] += $porcentagem;
                } else {
                    $notas[$n][$tipo] = "0.00";
                }
            }
        }

        // Cálculo da média anual
        $meses_media = 12 - count($meses_do_ano);  // Quantidade de meses considerados na média
        foreach ($media_anual as $m => $v) {
            if ($meses_media > 0) {
                $media_anual[$m] = number_format($v / $meses_media, 2, ',', '');
            } else {
                $media_anual[$m] = "0,00";
            }
        }

        // Retornando o resultado em um array
        return [
            'notas' => $notas,
            'media_anual' => $media_anual,
            'total_mensal' => $total_mensal,
            'total_chamados' => $total_chamados
        ];
    }

    public static function getQuantidadesMensal($selectedMonth = null, $selectedYear = null, $detalhado = null)
    {
        // Definindo os filtros de data
        $filtroData = isset($detalhado) ?
            "YEAR(CHADATAFINAL) = $selectedYear" :
            "MONTH(CHADATAFINAL) = $selectedMonth AND YEAR(CHADATAFINAL) = $selectedYear";

        $filtroData2 = isset($detalhado) ?
            "YEAR(CHADATA) = $selectedYear" :
            "MONTH(CHADATA) = $selectedMonth AND YEAR(CHADATA) = $selectedYear";

        // Query de chamados concluídos e cancelados
        $query = DB::connection('cal')->select("
        SELECT
            YEAR(C.CHADATAFINAL) AS ANO,
            MONTH(C.CHADATAFINAL) AS MES,
            C.STACODIGO,
            S.STADESCRICAO,
            COUNT(*) AS TOTAL_MENSAL
        FROM INCHAMADO C
        INNER JOIN inchastatus S ON S.STACODIGO = C.STACODIGO
        WHERE $filtroData
            AND C.STACODIGO IN (3, 4, 8)
            AND C.CHADATAFINAL IS NOT NULL
        GROUP BY YEAR(C.CHADATAFINAL), MONTH(C.CHADATAFINAL), C.STACODIGO, S.STADESCRICAO
    ");
        // dd($query); // Verifica o retorno de 'query'

        // Query de chamados abertos
        $query2 = DB::connection('cal')->select("
            SELECT
                YEAR(C.CHADATA) AS ANO,
                MONTH(C.CHADATA) AS MES,
                99 AS STACODIGO,
                'ABERTOS NO MES' AS STADESCRICAO,
                COUNT(*) AS TOTAL_MENSAL
            FROM INCHAMADO C
            WHERE $filtroData2
            GROUP BY YEAR(C.CHADATA), MONTH(C.CHADATA)
        ");
        // dd($query2);
        // Processamento dos resultados
        $resultadoBanco = array_merge($query, $query2);

        // dd($resultadoBanco);
        // dd($resultadoBanco);


        $totalAguardandoConcluido = 0;
        $statusChamados = [];

        foreach ($resultadoBanco as $status) {
            if (in_array($status->STACODIGO, [3, 8])) {
                $totalAguardandoConcluido += $status->TOTAL_MENSAL;
                $statusChamados['CONCLUÍDO'] = $totalAguardandoConcluido;
            } else {
                $statusChamados[$status->STADESCRICAO] = $status->TOTAL_MENSAL;
            }
        }

        // Cálculos dos totais e percentuais
        $totalGeral = $statusChamados['CONCLUÍDO'] + ($statusChamados['CANCELADO'] ?? 0);
        $statusChamados['totalchamados'] = $totalGeral;
        $statusChamados['PERCENTUAL_CONCLUIDO'] = round(($statusChamados['CONCLUÍDO'] / $totalGeral) * 100, 2);
        $statusChamados['PERCENTUAL_CANCELADO'] = round(($statusChamados['CANCELADO'] ?? 0 / $totalGeral) * 100, 2);

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
