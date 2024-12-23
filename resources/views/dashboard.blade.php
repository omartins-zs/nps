@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    <p>Bem-vindo ao sistema de NPS dos chamados de TI.</p>
    <p class="text-center">Mês: {{ $month }} Ano: {{ $year }}</p>
    <!-- Fieldset com link para abrir o modal -->
    <fieldset class="border-2 border-gray-300 rounded-lg p-4">
        <legend class="text-xl font-semibold text-gray-900 dark:text-white">
            <a href="#" data-modal-target="default-modal" data-modal-toggle="default-modal"
                class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Net Promoter Score
            </a>
        </legend>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-4">

            <!-- Card 1 - Qtde Chamados -->
            <a href="#"
                class="block max-w-sm p-6 bg-white border-t-4 border-black rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Qtde Chamados</h5>

                <ul class="font-normal text-gray-700 dark:text-gray-400">
                    <li> Estatico Em andamento: 5</li>
                    <li>Abertos: <span id="totalAbertos">0</span></li>
                    <li>Concluídos: <span id="totalConcluidos">0</span></li>
                    <li>Cancelados: <span id="totalCancelados">0</span></li>
                </ul>
            </a>

            <!-- Card 2 - NPS -->
            <a href="#"
                class="block max-w-sm p-6 bg-white border-t-4 border-{{ $nps->NPS['COR'] }}-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-lg font-semibold text-{{ $nps->NPS['COR'] }}-500">NPS</div>
                        <div class="h5 font-bold text-{{ $nps->NPS['COR'] }}-500">
                            {{ intval($nps->PORCENTAGEM) }}% / {{ $nps->NPS['NOTA'] }}
                        </div>
                    </div>
                    <i class="fas fa-{{ $nps->NPS['ICONE'] }} fa-2x text-{{ $nps->NPS['COR'] }}-500"></i>
                </div>
            </a>

            <!-- Card 3 - Todas -->
            <a href="#"
                class="block max-w-sm p-6 bg-white border-t-4 border-blue-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <h5 class="text-2xl font-bold text-gray-900 dark:text-white">Todas {{ $nps->NOTAS }}</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Total de Chamados</p>
                    </div>
                    <i class="fas fa-comments text-blue-500 fa-2x"></i>
                </div>
            </a>

            <!-- Card 4 - Promotores -->
            <a href="#"
                class="block max-w-sm p-6 bg-white border-t-4 border-green-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-lg font-semibold text-green-500">Promotores</div>
                        <div class="text-2xl font-bold">{{ $nps->PROMOTORES }}
                            ({{ number_format($nps->PROMOTORES_PORCENTAGEM, 0) }}%)</div>
                        <div class="progress mt-2 h-2 bg-gray-300 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: {{ intval($nps->PROMOTORES_PORCENTAGEM) }}%">
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-smile fa-2x text-green-500"></i>
                </div>
            </a>

            <!-- Card 5 - Neutros -->
            <a href="#"
                class="block max-w-sm p-6 bg-white border-t-4 border-yellow-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-lg font-semibold text-yellow-500">Neutros</div>
                        <div class="text-2xl font-bold">{{ $nps->NEUTROS }}
                            ({{ number_format($nps->NEUTROS_PORCENTAGEM, 0) }}%)</div>
                        <div class="progress mt-2 h-2 bg-gray-300 rounded-full overflow-hidden">
                            <div class="bg-yellow-500 h-full" style="width: {{ intval($nps->NEUTROS_PORCENTAGEM) }}%">
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-meh fa-2x text-yellow-500"></i>
                </div>
            </a>

            <!-- Card 6 - Detratores -->
            <a href="#"
                class="block max-w-sm p-6 bg-white border-t-4 border-red-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-lg font-semibold text-red-500">Detratores</div>
                        <div class="text-2xl font-bold">{{ $nps->DETRATORES }}
                            ({{ number_format($nps->DETRATORES_PORCENTAGEM, 0) }}%)</div>
                        <div class="progress mt-2 h-2 bg-gray-300 rounded-full overflow-hidden">
                            <div class="bg-red-500 h-full" style="width: {{ intval($nps->DETRATORES_PORCENTAGEM) }}%">
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-frown fa-2x text-red-500"></i>
                </div>
            </a>

        </div>
    </fieldset>

    <!-- Inclua o Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fieldset com cards contendo gráficos -->
    <fieldset class="border-2 border-gray-300 rounded-lg p-4 mt-6">
        <legend class="text-xl font-semibold text-gray-900 dark:text-white">
            <a href="#"
                class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Estatísticas de Atendimento
            </a>
        </legend>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <!-- Card 1 - Técnico -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-indigo-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-90">
                <a href="#" class="mb-4 block text-2xl font-bold text-indigo-600 hover:text-indigo-800">Técnico</a>
                <canvas id="tatendimentoChart" style="height: 100%; max-height: 250px;"></canvas>
            </div>

            <!-- Card 2 - Tempo -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-blue-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-90">
                <a href="#" class="mb-4 block text-2xl font-bold text-blue-600 hover:text-blue-800">Tempo</a>
                <canvas id="tempoChart" style="height: 100%; max-height: 250px;"></canvas>
            </div>

            <!-- Card 3 - Serviço Prestado -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-green-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-90">
                <a href="#" class="mb-4 block text-2xl font-bold text-green-600 hover:text-green-800">Serviço
                    Prestado</a>
                <canvas id="servicoChart" style="height: 100%; max-height: 250px;"></canvas>
            </div>

            <!-- Card 4 - Solicitação -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-red-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-90">
                <a href="#" class="mb-4 block text-2xl font-bold text-red-600 hover:text-red-800">Solicitação</a>
                <canvas id="solicitacaoChart" style="height: 100%; max-height: 250px;"></canvas>
            </div>
        </div>
    </fieldset>


    <!-- Fieldset com card de seleção de mês e ano -->
    <form id="comparacaoForm" method="POST" action="{{ route('comparar.chamados') }}">
        @csrf
        <div class="col-12">
            <fieldset class="border-2 border-gray-300 rounded-lg p-4 mt-6">
                <legend class="text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="#"
                        class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        Comparação de Chamados
                    </a>
                </legend>

                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                        <div class="col-span-1 grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="monthComparacao1" class="block text-sm font-medium text-gray-700">Mês 1</label>
                                <select id="monthComparacao1" name="monthComparacao1"
                                    class="form-control w-full py-2 px-3 border border-gray-300 rounded-md">
                                    @foreach ($meses as $mes => $nomeMes)
                                        <option value="{{ $mes }}" {{ $month == $mes ? 'selected' : '' }}>
                                            {{ $nomeMes }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="yearComparacao1" class="block text-sm font-medium text-gray-700">Ano 1</label>
                                <input type="number" id="yearComparacao1" name="yearComparacao1"
                                    class="form-control w-full py-2 px-3 border border-gray-300 rounded-md"
                                    value="{{ $year }}">
                            </div>
                        </div>

                        <div class="col-span-1 flex items-center gap-4">
                            <div class="mb-4 w-1/2">
                                <label for="monthComparacao2" class="block text-sm font-medium text-gray-700">Mês
                                    2</label>
                                <select id="monthComparacao2" name="monthComparacao2"
                                    class="form-control py-2 px-3 border border-gray-300 rounded-md w-full">
                                    @foreach ($meses as $mes => $nomeMes)
                                        <option value="{{ $mes }}">{{ $nomeMes }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 w-1/2">
                                <label for="yearComparacao2" class="block text-sm font-medium text-gray-700">Ano 2</label>
                                <input type="number" id="yearComparacao2" name="yearComparacao2"
                                    class="form-control py-2 px-3 border border-gray-300 rounded-md w-full"
                                    value="{{ $year }}">
                            </div>

                            <button type="submit"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:ring-2 focus:ring-gray-600 font-medium rounded-lg text-xs md:text-sm px-4 py-2.5 mt-1">
                                Consultar
                            </button>
                        </div>
                    </div>

                    <!-- Gráficos de Comparação -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 px-6 hidden" id="graficos-container">
                        <div
                            class="p-6 bg-white border-t-4 border-green-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <canvas id="graficocomparacao1" class="w-full "></canvas>
                        </div>
                        <div
                            class="p-6 bg-white border-t-4 border-red-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <canvas id="graficocomparacao2" class="w-full"></canvas>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>

    <!-- Fieldset com card para Indicador de Chamados Mensal -->
    <fieldset class="border-2 border-gray-300 rounded-lg p-4 mt-6">
        <legend class="text-xl font-semibold text-gray-900 dark:text-white">
            <a href="#"
                class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Indicador de Chamados Mensal
            </a>
        </legend>

        <!-- Card responsivo ocupando toda a largura com limite de altura -->
        <div class="w-full max-w-full col-span-12 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-4 max-h-[600px]">

            <!-- Card Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Chamados</h2>
                <div class="space-x-2 flex flex-wrap justify-end">
                    <!-- Botão para abrir modal de chamados cancelados -->
                    <button data-modal-target="modal-chamados-cancelados" data-modal-toggle="modal-chamados-cancelados"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs md:text-sm px-4 py-2.5">
                        Chamados Cancelados
                    </button>
                    <!-- Botão para o Indicador Anual com funcionalidade de mostrar/ocultar -->
                    <button id="indicadorAnualBtn"
                        class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 font-medium rounded-lg text-xs md:text-sm px-4 py-2.5">
                        Indicador Anual
                    </button>
                </div>
            </div>

            <!-- Card Body com Canvas -->
            <div class="card-body p-4 flex justify-center items-center w-full max-h-[450px]">
                <canvas id="chartCanvas" class="w-full h-full max-h-[450px]"></canvas>
            </div>
        </div>

    </fieldset>

    <!-- Indicador Chamados Anual (inicialmente oculto) -->
    <div id="indicadorAnual" class="hidden">
        <fieldset class="border-2 border-slate-500-300 rounded-lg p-4 mt-4">
            <legend class="text-lg font-semibold text-gray-900 dark:text-white">Indicador de Chamados Anual</legend>

            <!-- Card responsivo ocupando toda a largura com limite de altura -->
            <div class="w-full max-w-full col-span-12 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-4 max-h-[600px]">

                <!-- Card Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Chamados</h2>
                </div>

                <!-- Card Body com Canvas -->
                <div class="card-body p-4 flex justify-center items-center w-full max-h-[450px]">
                    <canvas id="GraficoLinhasAnual"
                        class="w-full h-full sm:max-h-[300px] md:max-h-[450px] lg:max-h-[500px]"></canvas>
                </div>
            </div>
        </fieldset>
    </div>


    <!-- Fieldset com card para Indicador de Chamados Mensal -->
    <fieldset class="border-2 border-gray-300 rounded-lg p-4 mt-6">
        <legend class="text-xl font-semibold text-gray-900 dark:text-white">
            <a href="#"
                class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Indicador Tempo de Conclusão Mensal (Quantidade)
            </a>
            <p class="ml-5 text-md text-gray-600">Chamados de Atendimento e Manutenção</p>

        </legend>

        <!-- Card responsivo ocupando toda a largura com limite de altura -->
        <div class="w-full max-w-full col-span-12 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-4 max-h-[600px]">

            <!-- Card Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tempo de Conclusão</h2>
                <div class="space-x-2 flex flex-wrap justify-end">
                    <!-- Botão para abrir modal de chamados cancelados -->
                    <button data-modal-target="small-modal" data-modal-toggle="small-modal"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs md:text-sm px-4 py-2.5">
                        Chamados + de 3 Dias
                    </button>
                    <!-- Botão para o Indicador Anual com funcionalidade de mostrar/ocultar -->
                    <button id="indicadorAnualBtnChamadosConcluidos"
                        class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 font-medium rounded-lg text-xs md:text-sm px-4 py-2.5">
                        Indicador Anual </button>
                </div>
            </div>

            <!-- Card Body com Canvas -->
            <div class="card-body p-4 flex justify-center items-center w-full max-h-[450px]">
                <canvas id="graficoMaisMenos3Dias" class="w-full h-full max-h-[450px]"></canvas>
            </div>
        </div>

    </fieldset>


    {{-- !-- Indicador Chamados Anual (inicialmente oculto) --> --}}
    <div id="indicadorAnualChamadosConclusao" class="hidden">
        <fieldset class="border-2 border-slate-500-300 rounded-lg p-4 mt-4">
            <legend class="text-lg font-semibold text-gray-900 dark:text-white">Indicador Tempo de Conclusão Anual
                (Quantidade)</legend>
            <p class="ml-5 text-md text-gray-600">Chamados de Atendimento e Manutenção</p>

            <!-- Card responsivo ocupando toda a largura com limite de altura -->
            <div class="w-full max-w-full col-span-12 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-4 max-h-[600px]">

                <!-- Card Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tempo de Conclusão</h2>
                </div>

                <!-- Card Body com Canvas -->
                <div class="card-body p-4 flex justify-center items-center w-full max-h-[450px]">
                    <canvas id="previsao_linha"
                        class="w-full h-full sm:max-h-[300px] md:max-h-[450px] lg:max-h-[450px]"></canvas>
                </div>
            </div>
        </fieldset>
    </div>



    <!-- Script para alternar a visibilidade do conteúdo -->
    {{-- <script>
        document.getElementById('indicadorAnualBtn').addEventListener('click', function() {
            const indicadorAnual = document.getElementById('indicadorAnual');
            indicadorAnual.classList.toggle('hidden');
        });
    </script> --}}



    <!-- Small Modal -->
    <div id="modal-chamados-cancelados" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Chamados cancelados
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-chamados-cancelados">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p>
                        @foreach ($codigosCancelados['CHAMADOS_CANCELADOS'] as $item)
                            <a href="https://intranet.casasandreluiz.org.br/intranet/antigo/informatica/admin/chaManutencao.php?CHACODIGO={{ $item }}&sSETOR=16&CHASTATUS=4&i_sat=0"
                                target="_blank">{{ $item }}</a> <br>
                        @endforeach
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modal-chamados-cancelados" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-gray-800 rounded-lg border border-gray-700 hover:bg-gray-700 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-500 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Small Modal -->
    <div id="small-modal" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Chamados com mais de 3 dias
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="small-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Setor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Qtde
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dados['setorContagem'] as $setor => $contagem)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-3">{{ $setor }}</td>
                                        <td class="px-6 py-3">{{ $contagem }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Exibindo os códigos com link -->
                    @foreach ($dados['codigos_mais_que_tres'] as $item)
                        @php
                            [$chacodigo, $setdescricao, $dias] = explode(':', $item);
                        @endphp
                        <a href="https://intranet.casasandreluiz.org.br/intranet/antigo/informatica/admin/chaManutencao.php?CHACODIGO={{ $chacodigo }}"
                            target="_blank" class="text-blue-600 hover:text-blue-800 underline">{{ $chacodigo }}</a>
                        - {{ $setdescricao }} ({{ $dias }} dias)<br>
                    @endforeach
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="small-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-gray-800 rounded-lg border border-gray-700 hover:bg-gray-700 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-500 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full"> <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Net Promoter Score Details
                    </h3>
                    <!-- Button to close the modal -->
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">

                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="default-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts de Comparação Livewire --}}
    <script></script>

    {{-- Charts de Comparação Estatico  --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('comparacaoForm');
            let chart1, chart2; // Variáveis para armazenar os gráficos

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Evita o envio padrão do formulário

                const formData = new FormData(form);

                fetch("{{ route('comparar.chamados') }}", {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json()) // Espera a resposta no formato JSON
                    .then(data => {
                        // Exibe os dados recebidos no console (opcional)
                        console.log(data);

                        // Se já existir gráfico1, destruímos
                        if (chart1) {
                            chart1.destroy();
                        }
                        if (chart2) {
                            chart2.destroy();
                        }

                        // Preenche os gráficos com os dados recebidos
                        updateCharts(data);
                    })
                    .catch(error => {
                        console.error("Erro ao enviar os dados:", error);
                    });
            });

            // Função para atualizar os gráficos com os dados recebidos
            function updateCharts(data) {
                const ctx1 = document.getElementById('graficocomparacao1');
                const ctx2 = document.getElementById('graficocomparacao2');
                const container = document.getElementById('graficos-container');

                if (!ctx1 || !ctx2 || !container) {
                    console.error("Não foi possível encontrar os elementos necessários.");
                    return; // Se não encontrar os elementos canvas, não tenta criar os gráficos
                }

                // Remover classe "hidden" para exibir os gráficos
                container.classList.remove('hidden');

                const mes1Data = data.mes1.dados;
                const mes2Data = data.mes2.dados;

                const chartData1 = {
                    labels: ['ABERTOS', 'CONCLUÍDOS'],
                    datasets: [{
                        label: `ABERTOS (${data.mes1.mes}/${data.mes1.ano})`,
                        data: [mes1Data.ABERTOS, 0],
                        backgroundColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }, {
                        label: `CONCLUÍDOS (${data.mes1.mes}/${data.mes1.ano})`,
                        data: [0, mes1Data.CONCLUIDO],
                        backgroundColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                };

                const chartData2 = {
                    labels: ['ABERTOS', 'CONCLUÍDOS'],
                    datasets: [{
                        label: `ABERTOS (${data.mes2.mes}/${data.mes2.ano})`,
                        data: [mes2Data.ABERTOS, 0],
                        backgroundColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }, {
                        label: `CONCLUÍDOS (${data.mes2.mes}/${data.mes2.ano})`,
                        data: [0, mes2Data.CONCLUIDO],
                        backgroundColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                };

                // Criação dos gráficos (mesmo código anterior)
                chart1 = new Chart(ctx1, {
                    type: 'bar',
                    data: chartData1,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 50,
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 0,
                                    minRotation: 0
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    title: function(tooltipItem) {
                                        return tooltipItem[0].label;
                                    },
                                    label: function(tooltipItem) {
                                        const datasetLabel = tooltipItem.dataset.label || '';
                                        const value = tooltipItem.raw;
                                        return `${datasetLabel}: ${value}`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Cria o gráfico para o segundo canvas (graficocomparacao2)
                chart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: chartData2,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 50,
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 0,
                                    minRotation: 0
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    title: function(tooltipItem) {
                                        return tooltipItem[0].label;
                                    },
                                    label: function(tooltipItem) {
                                        const datasetLabel = tooltipItem.dataset.label || '';
                                        const value = tooltipItem.raw;
                                        return `${datasetLabel}: ${value}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script> --}}

    {{-- Charts de Teste --}}

    {{-- <script>
        //  Gráfico para o Card "Técnico"
        const tecnicoChart = new Chart(document.getElementById('tecnicoChart'), {
            type: 'pie',
            data: {
                labels: ['Técnico A', 'Técnico B', 'Técnico C'],
                datasets: [{
                    label: 'Atendimentos',
                    data: [35, 25, 40],
                    backgroundColor: ['#4F46E5', '#3B82F6', '#9333EA']
                }]
            },
        });

        //  Gráfico para o Card "Tempo"
        const tempoChart = new Chart(document.getElementById('tempoChart'), {
            type: 'bar',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
                datasets: [{
                    label: 'Tempo Médio (horas)',
                    data: [2.5, 3, 1.5, 4],
                    backgroundColor: '#60A5FA'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
        //   Gráfico para o Card "Serviço Prestado"

        const servicoChart = new Chart(document.getElementById('servicoChart'), {
            type: 'doughnut',
            data: {
                labels: ['Manutenção', 'Instalação', 'Suporte'],
                datasets: [{
                    label: 'Serviços',
                    data: [45, 30, 25],
                    backgroundColor: ['#34D399', '#10B981', '#059669']
                }]
            }
        });

        //   Gráfico para o Card "Solicitação"
        const solicitacaoChart = new Chart(document.getElementById('solicitacaoChart'), {
            type: 'line',
            data: {
                labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                datasets: [{
                    label: 'Solicitações',
                    data: [12, 19, 8, 15],
                    borderColor: '#F87171',
                    backgroundColor: 'rgba(248, 113, 113, 0.2)',
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </> --}}

    {{-- <script>
        let graficosPrevisao = {};

        async function graficoMaisMenos3Dias() {
            const selectedMonth = document.querySelector('#selectedMonth').value;
            const selectedYear = document.querySelector('#selectedYear').value;
            const base_url = `/graficoPrevisao/${selectedMonth}/${selectedYear}`;

            if (graficosPrevisao["graficoPrevisao"]) return; // Evita recriar o gráfico se já existir

            try {
                const response = await fetch(base_url);
                const resultado = await response.json();

                console.log("Mensal", resultado);

                // Definindo status e valores do gráfico
                const status = ['Menor ou igual a 3 dias', 'Mais de 3 dias'];
                const valores = [
                    resultado[0].percentagem_menor_igual_tres,
                    resultado[0].percentagem_maior_que_tres
                ];
                const valor = [
                    resultado[0].qtd_menor_igual_tres,
                    resultado[0].qtd_maior_que_tres
                ];

                // Configuração dos datasets para o gráfico
                const datasets = [{
                        label: `${status[0]} (${valores[0]}%)`,
                        data: [valor[0]],
                        backgroundColor: '#28a745',
                    },
                    {
                        label: `${status[1]} (${valores[1]}%)`,
                        data: [valor[1]],
                        backgroundColor: '#dc3545',
                    }
                ];

                // Destroi o gráfico anterior, se existir
                if (graficosPrevisao["graficoPrevisao"]) {
                    graficosPrevisao["graficoPrevisao"].destroy();
                }

                // Cria o gráfico
                const ctx = document.getElementById("graficoMaisMenos3Dias").getContext("2d");
                graficosPrevisao["graficoPrevisao"] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [''], // Sem labels no eixo X
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.raw}`;
                                    }
                                },
                                backgroundColor: "rgb(255,255,255)",
                                bodyColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                            }
                        },
                        scales: {
                            x: {
                                display: false // Oculta o eixo X
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 10
                                }
                            }
                        }
                    }
                });

            } catch (error) {
                console.error("Erro ao obter os dados:", error);
            }
        }

        // Executa a função ao carregar a página
        document.addEventListener('DOMContentLoaded', graficoMaisMenos3Dias);
    </script> --}}

    <!-- Script para alternar a visibilidade do conteúdo e gerar o gráfico -->
    {{-- <script>
        document.getElementById('indicadorAnualBtnChamadosConcluidos').addEventListener('click', async function() {
            const indicadorAnualChamadosConclusao = document.getElementById('indicadorAnualChamadosConclusao');

            // Alterna a visibilidade do fieldset
            indicadorAnualChamadosConclusao.classList.toggle('hidden');

            // Verifica se o fieldset está visível e gera o gráfico se estiver
            if (!indicadorAnualChamadosConclusao.classList.contains('hidden')) {
                // Chama a função de geração do gráfico
                await geraGraficoLinhasPrevisao();
            }
        });

        async function geraGraficoLinhasPrevisao() {
            const selectedMonth = document.querySelector('#selectedMonth').value;
            const selectedYear = document.querySelector('#selectedYear').value;
            const base_url = `/graficoPrevisaoLinhaMeses/${selectedMonth}/${selectedYear}/1`;

            try {
                const response = await fetch(base_url);
                const resultado = await response.json();
                console.log('Anual', resultado);
                const valores_mais = [];
                const valores_menos = [];

                resultado.forEach(item => {
                    valores_mais.push(item.percentagem_maior_que_tres);
                    valores_menos.push(item.percentagem_menor_igual_tres);
                });

                geraLinhasPrevisao([valores_mais, valores_menos], selectedYear);
            } catch (error) {
                console.error("Erro ao carregar os dados:", error);
            }
        }

        function geraLinhasPrevisao(valores, selectedYear) {
            const ctx = document.getElementById('previsao_linha').getContext('2d');
            const meses = [
                'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];

            // Destruir gráfico existente para evitar sobreposição
            if (window.previsaoLinhaChart) {
                window.previsaoLinhaChart.destroy();
            }

            // Criação do gráfico e atribuição ao window para controle global
            window.previsaoLinhaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                            label: 'Mais de 3 dias (%)',
                            data: valores[0],
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        },
                        {
                            label: 'Menos ou igual a 3 dias (%)',
                            data: valores[1],
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Permite o gráfico ocupar a largura total
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: `Ano: ${selectedYear}` // Exibe o ano no título
                        }
                    }
                }
            });
        }
    </script> --}}


    {{-- <script>
        const graficos = {};

        async function geraGraficoChamados(id, nomeChart) {
            const selectedMonth = document.querySelector('#selectedMonth').value;
            const selectedYear = document.querySelector('#selectedYear').value;

            if (graficos[nomeChart]) return; // Evita recriar o gráfico se já existir

            try {
                const response = await fetch(`/grafico/${selectedMonth}/${selectedYear}`);
                const resultado = await response.json();
                // console.log(resultado)
                // Extrai os valores do resultado
                const status = [];
                const valores = [];
                const cores = []; // Array para armazenar as cores de cada status
                const percentuais = []; // Array para armazenar as cores de cada status

                // Adicionando os dados de cada status
                if (resultado['CONCLUÍDO'] !== undefined) {
                    status.push('CONCLUÍDO');
                    valores.push(resultado['CONCLUÍDO']);
                    percentuais['CONCLUÍDO'] = (resultado['CONCLUÍDO'] / resultado['totalchamados']) *
                        100; // Calculando a porcentagem corretamente
                    cores.push('#28a745'); // Cor verde para CONCLUÍDO
                }
                if (resultado['CANCELADO'] !== undefined) {
                    status.push('CANCELADO');
                    valores.push(resultado['CANCELADO']);
                    percentuais['CANCELADO'] = (resultado['CANCELADO'] / resultado['totalchamados']) *
                        100; // Calculando a porcentagem corretamente

                    cores.push('#dc3545'); // Cor vermelha para CANCELADO
                }
                if (resultado['ABERTOS NO MES'] !== undefined) {
                    status.push('ABERTOS NO MES');
                    valores.push(resultado['ABERTOS NO MES']);
                    percentuais['ABERTOS NO MES'] = (resultado['ABERTOS NO MES'] / resultado['totalchamados']) *
                        100; // Calculando a porcentagem corretamente
                    cores.push('#007bff'); // Cor azul para ABERTOS NO MES
                }

                // console.log("Valores", valores);
                // console.log("Status", status);
                // console.log("Percentuais", percentuais);

                // Atualizando os valores no card
                document.querySelector('#totalAbertos').textContent = resultado['ABERTOS NO MES'] || 0;
                document.querySelector('#totalConcluidos').textContent = resultado['CONCLUÍDO'] || 0;
                document.querySelector('#totalCancelados').textContent = resultado['CANCELADO'] || 0;

                // Criando os datasets para o gráfico (um dataset para cada barra)
                const datasets = status.map((stat, index) => {
                    return {
                        label: stat, // Label com o nome do status
                        data: [valores[index]], // Valores de cada status
                        backgroundColor: cores[index], // Cor do status
                        borderColor: cores[index], // Cor da borda da barra
                        borderWidth: 1,
                    };
                });

                // Criando o gráfico de barras
                const ctx = document.getElementById(nomeChart).getContext('2d');
                graficos[nomeChart] = new Chart(ctx, {
                    type: 'bar', // Usando gráfico de barras
                    data: {
                        labels: [''], // Não exibindo rótulos no eixo X
                        datasets: datasets, // Colocando os datasets no gráfico
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        // Obtém a quantidade do gráfico (valor da barra)
                                        const quantidade = context.raw;
                                        // Exibe apenas a quantidade no tooltip
                                        return `${quantidade}`;
                                    }
                                },
                                backgroundColor: "rgb(255,255,255)",
                                bodyColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                            },
                        },
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10,
                            },
                        },
                        scales: {
                            x: {
                                display: false, // Desativa o eixo X
                            },
                            y: {
                                beginAtZero: true, // Garante que o gráfico de barras começa do zero
                                ticks: {
                                    stepSize: 10, // Define o intervalo dos ticks no eixo Y
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error("Erro ao gerar gráfico:", error);
            }
        }

        // Função para gerar todos os gráficos
        async function gerarTodosGraficos() {
            await Promise.all([
                geraGraficoChamados(1, "chartCanvas")
            ]);
        }

        // Executa a geração dos gráficos ao carregar a página
        document.addEventListener('DOMContentLoaded', gerarTodosGraficos);
    </script> --}}

    <script>
        const charts = {};

        async function geraGrafico(id, nomeChart) {
            const selectedMonth = document.querySelector('#selectedMonth').value;
            const selectedYear = document.querySelector('#selectedYear').value;

            const url = `/relatorio-indicadores-json/${selectedMonth}/${selectedYear}/${id}`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                console.log("Dados da API:", data);

                // Verifica se existem dados válidos
                if (!data || !data.media_anual || Object.keys(data.media_anual).every(key => parseFloat(data
                        .media_anual[key].replace(",", ".")) === 0)) {
                    console.warn("Os dados retornados são inválidos ou todos os valores são zerados.");
                    return;
                }

                const labels = Object.keys(data.media_anual);
                const values = Object.values(data.media_anual).map(value => parseFloat(value.replace(",", ".")));

                const ctx = document.getElementById(nomeChart).getContext('2d');
                if (charts[nomeChart]) {
                    charts[nomeChart].data.labels = labels;
                    charts[nomeChart].data.datasets[0].data = values;
                    charts[nomeChart].update();
                } else {
                    charts[nomeChart] = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw.toFixed(2);
                                            return `${label}: ${value}%`;
                                        }
                                    },
                                    backgroundColor: "rgb(255,255,255)",
                                    bodyColor: "#858796",
                                    borderColor: '#dddfeb',
                                    borderWidth: 1
                                }
                            },
                            layout: {
                                padding: {
                                    top: 10,
                                    bottom: 10
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error("Erro ao gerar o gráfico:", error);
            }
        }

        async function gerarGraficos() {
            await Promise.all([
                geraGrafico(2, "tecnicoChart"),
                geraGrafico(1, "tempoChart"),
                geraGrafico(4, "servicoChart"),
                geraGrafico(3, "solicitacaoChart")
            ]);
        }

        document.addEventListener('DOMContentLoaded', gerarGraficos);
    </script>

    <!-- Script para alternar a visibilidade do conteúdo e gerar o gráfico -->
    <script>
        document.getElementById('indicadorAnualBtn').addEventListener('click', async function() {
            const indicadorAnual = document.getElementById('indicadorAnual');
            indicadorAnual.classList.toggle('hidden');

            // Gera o gráfico apenas uma vez, se ele não tiver sido criado ainda
            if (!window.graficoLinhasAnual) {
                await geraGraficoLinhas();
            }
        });

        // Função principal para gerar o gráfico
        async function geraGraficoLinhas() {
            const selectedMonth = document.querySelector('#selectedMonth').value;
            const selectedYear = document.querySelector('#selectedYear').value;
            const base_url2 = `/graficoLinhaMeses/${selectedMonth}/${selectedYear}/1`;

            try {
                const response = await fetch(base_url2);
                const resultado = await response.json();

                var tipos_status = [99, 3, 4, 6, 8];
                var status = [];
                tipos_status.forEach(item => {
                    status[item] = [];
                });

                resultado.forEach(item => {
                    var st = item.STACODIGO;
                    var m = item.MES - 1;
                    var qtd = item.TOTAL_MENSAL;
                    status[st][m] = qtd;
                });

                geraLinhas(status);
            } catch (error) {
                console.error("Erro ao carregar os dados:", error);
            }
        }

        // Função para gerar o gráfico de linhas
        function geraLinhas(status) {
            const ctx = document.getElementById('GraficoLinhasAnual').getContext('2d');
            const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro',
                'Outubro', 'Novembro', 'Dezembro'
            ];

            // Cria o gráfico e armazena a instância para evitar recriações
            window.graficoLinhasAnual = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                            label: 'Concluído',
                            data: status[3] || [],
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        },
                        {
                            label: 'Abertos',
                            data: status[99] || [],
                            backgroundColor: '#ffc107',
                            borderColor: '#ffc107',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        },
                        {
                            label: 'Cancelado',
                            data: status[4] || [],
                            backgroundColor: '#FF0000',
                            borderColor: '#FF0000',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        },
                        {
                            label: 'Aguardando Revisão',
                            data: status[6] || [],
                            backgroundColor: '#BBBBBB',
                            borderColor: '#BBBBBB',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        },
                        {
                            label: 'Aguardando Avaliação',
                            data: status[8] || [],
                            backgroundColor: '#0000FF',
                            borderColor: '#0000FF',
                            borderWidth: 2,
                            pointBorderWidth: 2.5,
                            fill: false,
                        }
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Ajuste para responsividade
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Indicadores de Chamados Anuais',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
    </script>
@endsection
