@extends('layouts.app')

@section('title', 'Dashboard NPS')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded shadow">

        <!-- Seleção de Mês e Ano -->
        <form action="{{ route('dashboard.index') }}" method="GET" class="mb-6 flex gap-4">
            <select name="month" class="border rounded px-4 py-2 dark:bg-gray-800 dark:text-white">
                @foreach ($meses as $key => $mes)
                    <option value="{{ $key }}" {{ $key == $month ? 'selected' : '' }}>{{ $mes }}</option>
                @endforeach
            </select>
            <select name="year" class="border rounded px-4 py-2 dark:bg-gray-800 dark:text-white">
                @for ($y = now()->format('Y') - 5; $y <= now()->format('Y'); $y++)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">Filtrar</button>
        </form>

        <!-- Fieldset com dados NPS -->
        <fieldset class="border-2 border-gray-300 dark:border-gray-700 rounded-lg p-4">
            <legend class="text-xl font-semibold text-gray-900 dark:text-white">
                <a href="#"
                    class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Net Promoter Score Mensal
                </a>
            </legend>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                <!-- Card 1 - NPS Mensal -->
                <div
                    class="block max-w-sm p-6 bg-white border-t-4 border-blue-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h5 class="text-2xl font-bold text-gray-900 dark:text-white">NPS Mensal</h5>
                            <p class="font-normal text-{{ $nps->NPS_RATING['COLOR'] }}-500">{{ $nps->NPS_PERCENT }}%</p>
                        </div>
                        <i
                            class="fas fa-{{ $nps->NPS_RATING['ICON'] }} fa-2x text-{{ $nps->NPS_RATING['COLOR'] }}-500"></i>
                    </div>
                </div>

                <!-- Card 2 - Promotores -->
                <div
                    class="block max-w-sm p-6 bg-white border-t-4 border-green-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h5 class="text-lg font-semibold text-green-500">Promotores</h5>
                            <p class="text-2xl font-bold">{{ $nps->PROMOTERS }} ({{ $nps->PROMOTERS_PERCENT }}%)</p>
                        </div>
                        <i class="fas fa-smile fa-2x text-green-500"></i>
                    </div>
                </div>

                <!-- Card 3 - Passivos -->
                <div
                    class="block max-w-sm p-6 bg-white border-t-4 border-yellow-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h5 class="text-lg font-semibold text-yellow-500">Passivos</h5>
                            <p class="text-2xl font-bold">{{ $nps->PASSIVES }} ({{ $nps->PASSIVES_PERCENT }}%)</p>
                        </div>
                        <i class="fas fa-meh fa-2x text-yellow-500"></i>
                    </div>
                </div>

                <!-- Card 4 - Detratores -->
                <div
                    class="block max-w-sm p-6 bg-white border-t-4 border-red-500 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h5 class="text-lg font-semibold text-red-500">Detratores</h5>
                            <p class="text-2xl font-bold">{{ $nps->DETRACTORS }} ({{ $nps->DETRACTORS_PERCENT }}%)</p>
                        </div>
                        <i class="fas fa-frown fa-2x text-red-500"></i>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Gráfico de NPS -->
        <div class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Distribuição NPS</h3>
            <canvas id="npsDoughnutChart" class="w-full max-w-md mx-auto"></canvas>
        </div>
    </div>

    <!-- Adicione o script do Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('npsDoughnutChart').getContext('2d');

            // Buscar dados do gráfico
            fetch("{{ route('dashboard.chartData') }}?month={{ $month }}&year={{ $year }}")
                .then(response => response.json())
                .then(data => {
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: data.colors,
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                            }
                        }
                    });
                })
                .catch(error => console.error('Erro ao carregar os dados do gráfico:', error));
        });
    </script>
@endsection
