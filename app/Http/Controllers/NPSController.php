<?php

namespace App\Http\Controllers;

// use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Nps;

class NPSController extends Controller
{
    public function index(Request $request)
    {
        $nps = new Nps();
        $user = session('UserLogado');

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        try {
            // Tenta fazer a requisição para a API
            $sistemasJson = Http::withOptions(['verify' => false, 'timeout' => 5])
                ->get('https://appcal.casasandreluiz.org.br/Api_Sistemas_Web_laravel/Api/buscaAplicativosNomeLink');


            $sistemas = $sistemasJson->json();
        } catch (\Exception $e) {
            // Captura o erro e usa dados fictícios em caso de falha de conexão
            $sistemas = [
                [
                    'descricao' => 'Sistema de Portaria',
                    'link' => 'https://exemplo.com/portaria',
                    'icone' => 'https://via.placeholder.com/40x40?text=Portaria'
                ],
                [
                    'descricao' => 'Autorização de Saída',
                    'link' => 'https://exemplo.com/autorizacao',
                    'icone' => 'https://via.placeholder.com/40x40?text=Saida'
                ],
                [
                    'descricao' => 'Doações',
                    'link' => 'https://exemplo.com/doacoes',
                    'icone' => 'https://via.placeholder.com/40x40?text=Doacoes'
                ]
            ];
        }

        $nps = Nps::getNps($month, $year);
        // Obtém os meses disponíveis através do helper Meses_Do_Ano
        $meses = Meses_Do_Ano();

        $graficoMaisMenos3Dias = Nps::getMediaConclusaoChamados($month, $year);

        $codigosCancelados =  Nps::getChamadosCancelados($month, $year);

        $dados['chamados_mais_que_tres'] = $graficoMaisMenos3Dias;
        $dados['codigos_mais_que_tres'] = $graficoMaisMenos3Dias[0]->CHAMADOS_MAIOR_QUE_TRES; // Sem o explode, pois já é um array
        $dados['setorContagem'] = $graficoMaisMenos3Dias[0]->contagemPorSetor;

        // Adicionando os indicadores específicos
        $relatorioIndicadores = [
            'tempo' => Nps::relatorioIndicadores($month, $year, 1),
            'tecnico' => Nps::relatorioIndicadores($month, $year, 2),
            'solicitacao' => Nps::relatorioIndicadores($month, $year, 3),
            'servico' => Nps::relatorioIndicadores($month, $year, 4)
        ];

        // $dadosComparacao = session('dadosComparacao', []);
        $dadosComparacao = session('dadosComparacao', []);


        // dd($dadosComparacao);

        return view('dashboard', compact('nps', 'month', 'year', 'relatorioIndicadores', 'dados', 'codigosCancelados', 'meses', 'dadosComparacao', 'sistemas', 'user'));
    }

    public function relatorioIndicadoresJson(Request $request, $selectedMonth, $selectedYear, $avacodigo)
    {
        $indicadores = Nps::relatorioIndicadores($selectedMonth, $selectedYear, $avacodigo);

        return response()->json($indicadores);
    }

    public function grafico($selectedMonth, $selectedYear)
    {
        $graficosChamados = Nps::getQuantidadesMensal($selectedMonth, $selectedYear);
        // dd($graficosChamados);

        return response()->json($graficosChamados);
    }

    public function graficoLinhaMeses($selectedMonth, $selectedYear, $detalhado)
    {
        $graficoChamadosLinhaMeses = Nps::getQuantidadesMensal($selectedMonth, $selectedYear, $detalhado);

        return response()->json($graficoChamadosLinhaMeses);
    }

    public function graficoPrevisao($selectedMonth, $selectedYear)
    {
        $graficoMaisMenos3Dias = Nps::getMediaConclusaoChamados($selectedMonth, $selectedYear);

        // Verificar se a consulta retornou dados
        if (empty($graficoMaisMenos3Dias)) {
            return response()->json(['message' => 'Nenhum dado encontrado'], 404);
        }

        return response()->json($graficoMaisMenos3Dias);
    }

    public function graficoPrevisaoLinhaMeses($selectedMonth, $selectedYear, $detalhado)
    {

        // dump($selectedMonth);
        // dump($selectedYear);
        // dump($detalhado);
        $graficoMediaConclusao = Nps::getMediaConclusaoChamados($selectedMonth, $selectedYear, $detalhado);
        // dd($graficoMediaConclusao);
        // Verificar se a consulta retornou dados
        if (empty($graficoMediaConclusao)) {
            return response()->json(['message' => 'Nenhum dado encontrado'], 404);
        }
        return response()->json($graficoMediaConclusao);

        // dd($graficoMaisMenos3DiasLinhaMeses);

    }

    public function comparar(Request $request)
    {
        // dd($request->all()); // Verifique todos os dados enviados

        // Recebe os parâmetros da requisição
        $month1 = $request->input('monthComparacao1');
        $year1 = $request->input('yearComparacao1');
        $month2 = $request->input('monthComparacao2');
        $year2 = $request->input('yearComparacao2');

        // dump($month1, $year1, $month2, $year2);

        // Busca os dados de comparação
        $dadosComparacao = Nps::compararChamados($month1, $year1, $month2, $year2);

        // dd($dadosComparacao);

        // Retorna a resposta JSON com os dados de comparação
        return response()->json($dadosComparacao);



        // Armazena os dados de comparação na sessão de forma temporária
        // session()->flash('dadosComparacao', $dadosComparacao);

        // session(['dadosComparacao' => $dadosComparacao]);

        // Redireciona para o dashboard com os dados de comparação
        // return redirect()->route('dashboard');
        // return redirect()->route('dashboard');

        // return response()->json($dadosComparacao);

        // return redirect()->route('dashboard')->with('dadosComparacao', $dadosComparacao);

    }
}
