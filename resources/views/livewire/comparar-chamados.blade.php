<div>
    <form wire:submit.prevent="atualizarGraficos">
        <fieldset class="border-2 border-gray-300 rounded-lg p-4 mt-6">
            <legend class="text-xl font-semibold text-gray-900 dark:text-white">
                <a href="#" class="cursor-pointer text-blue-700 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Comparação de Chamados
                </a>
            </legend>

            <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                    <div class="col-span-1 grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="month1" class="block text-sm font-medium text-gray-700">Mês 1</label>
                            <select wire:model="monthComparacao1" id="monthComparacao1" name="monthComparacao1"
                                class="form-control w-full py-2 px-3 border border-gray-300 rounded-md">
                                @foreach ($meses as $mes => $nomeMes)
                                    <option value="{{ $mes }}">{{ $nomeMes }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="year1" class="block text-sm font-medium text-gray-700">Ano 1</label>
                            <input type="number" wire:model="yearComparacao1" id="yearComparacao1" name="yearComparacao1"
                                class="form-control w-full py-2 px-3 border border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="col-span-1 flex items-center gap-4">
                        <div class="mb-4 w-1/2">
                            <label for="month2" class="block text-sm font-medium text-gray-700">Mês 2</label>
                            <select wire:model="monthComparacao2" id="monthComparacao2" name="monthComparacao2"
                                class="form-control py-2 px-3 border border-gray-300 rounded-md w-full">
                                @foreach ($meses as $mes => $nomeMes)
                                    <option value="{{ $mes }}">{{ $nomeMes }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 w-1/2">
                            <label for="year2" class="block text-sm font-medium text-gray-700">Ano 2</label>
                            <input type="number" wire:model="yearComparacao2" id="yearComparacao2" name="yearComparacao2"
                                class="form-control py-2 px-3 border border-gray-300 rounded-md w-full">
                        </div>

                        <button type="submit"
                            class="text-white bg-gray-800 hover:bg-gray-900 focus:ring-2 focus:ring-gray-600 font-medium rounded-lg text-xs md:text-sm px-4 py-2.5 mt-1">
                            Consultar
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 px-6">
                    <div class="p-6 bg-white border-t-4 border-green-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <canvas id="graficocomparacao1" style="height: 100%; max-height: 250px;"></canvas>
                    </div>

                    <div class="p-6 bg-white border-t-4 border-red-500 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <canvas id="graficocomparacao2" style="height: 100%; max-height: 250px;"></canvas>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
