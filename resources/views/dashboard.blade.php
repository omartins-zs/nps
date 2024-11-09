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
                    <li>Abertos: 10</li>
                    <li>Em andamento: 5</li>
                    <li>Concluídos: 8</li>
                    <li>Cancelados: 2</li>
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
                        <div class="text-2xl font-bold">{{ $nps->PROMOTORES }} ({{ number_format($nps->PROMOTORES_PORCENTAGEM, 0) }}%)</div>
                        <div class="progress mt-2 h-2 bg-gray-300 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full" style="width: {{ intval($nps->PROMOTORES_PORCENTAGEM) }}%"></div>
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
                        <div class="text-2xl font-bold">{{ $nps->NEUTROS }} ({{ number_format($nps->NEUTROS_PORCENTAGEM, 0) }}%)</div>
                        <div class="progress mt-2 h-2 bg-gray-300 rounded-full overflow-hidden">
                            <div class="bg-yellow-500 h-full" style="width: {{ intval($nps->NEUTROS_PORCENTAGEM) }}%"></div>
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
                        <div class="text-2xl font-bold">{{ $nps->DETRATORES }} ({{ number_format($nps->DETRATORES_PORCENTAGEM, 0) }}%)</div>
                        <div class="progress mt-2 h-2 bg-gray-300 rounded-full overflow-hidden">
                            <div class="bg-red-500 h-full" style="width: {{ intval($nps->DETRATORES_PORCENTAGEM) }}%"></div>
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
                class="max-w-sm p-6 bg-white border-t-4 border-indigo-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#" class="mb-4 block text-2xl font-bold text-indigo-600 hover:text-indigo-800">Técnico</a>
                <canvas id="tecnicoChart"></canvas>
            </div>

            <!-- Card 2 - Tempo -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-blue-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#" class="mb-4 block text-2xl font-bold text-blue-600 hover:text-blue-800">Tempo</a>
                <canvas id="tempoChart"></canvas>
            </div>

            <!-- Card 3 - Serviço Prestado -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-green-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#" class="mb-4 block text-2xl font-bold text-green-600 hover:text-green-800">Serviço
                    Prestado</a>
                <canvas id="servicoChart"></canvas>
            </div>

            <!-- Card 4 - Solicitação -->
            <div
                class="max-w-sm p-6 bg-white border-t-4 border-red-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#" class="mb-4 block text-2xl font-bold text-red-600 hover:text-red-800">Solicitação</a>
                <canvas id="solicitacaoChart"></canvas>
            </div>
        </div>
    </fieldset>

    {{-- <script>
        // Gráfico para o Card "Técnico"
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

        // Gráfico para o Card "Tempo"
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
        });

        // Gráfico para o Card "Serviço Prestado"
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

        // Gráfico para o Card "Solicitação"
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
    </script> --}}


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
@endsection
