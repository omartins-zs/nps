<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CompararChamados extends Component
 {
//     public $monthComparacao1;
//     public $yearComparacao1;
//     public $monthComparacao2;
//     public $yearComparacao2;
//     public $dadosComparacao1 = [];
//     public $dadosComparacao2 = [];
//     public $meses;

//     public function mount()
//     {
//         // Inicializa os meses e os valores padrão para as datas
//         $this->meses = [
//             1 => 'Janeiro',
//             2 => 'Fevereiro',
//             3 => 'Março',
//             4 => 'Abril',
//             5 => 'Maio',
//             6 => 'Junho',
//             7 => 'Julho',
//             8 => 'Agosto',
//             9 => 'Setembro',
//             10 => 'Outubro',
//             11 => 'Novembro',
//             12 => 'Dezembro'
//         ];
//         $this->monthComparacao1 = date('m');
//         $this->yearComparacao1 = date('Y');
//         $this->monthComparacao2 = date('m');
//         $this->yearComparacao2 = date('Y');
//     }

//     public function gerarGraficoComparacao()
//     {
//         // Dados simulados para exibir no gráfico
//         $this->dadosComparacao1 = [
//             'ABERTOS' => rand(5, 20),
//             'CONCLUIDO' => rand(5, 20)
//         ];

//         $this->dadosComparacao2 = [
//             'ABERTOS' => rand(5, 20),
//             'CONCLUIDO' => rand(5, 20)
//         ];

//         // Emite um evento para atualizar o gráfico no frontend
//         $this->emit('atualizarGrafico', $this->dadosComparacao1, $this->dadosComparacao2);
//     }

//     public function render()
//     {
//         return view('livewire.comparar-chamados');
//     }
}
