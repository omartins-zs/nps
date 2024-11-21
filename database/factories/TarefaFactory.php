<?php

namespace Database\Factories;

use App\Models\Chamado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarefa>
 */
class TarefaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dataPrevisao = $this->faker->dateTimeBetween('2024-01-01', '2024-12-31');
        $dataFinalizacao = $this->faker->optional()->dateTimeBetween($dataPrevisao, '2024-12-31'); // Opcional e posterior a dataPrevisao

        return [
            'chamado_id' => Chamado::inRandomOrder()->first()->id, // Associando a um chamado aleatório
            'tipo_tarefa' => $this->faker->randomElement(['atendimento', 'melhoria', 'novo projeto', 'manutencao']),
            'horas_gastas' => $this->faker->randomFloat(2, 0, 8), // Horas gastas aleatórias (até 8 horas)
            'horas_previstas' => $this->faker->randomFloat(2, 0, 8), // Horas previstas aleatórias (até 8 horas)
            'status' => $this->faker->randomElement(['em andamento', 'concluida']),
            'descricao' => $this->faker->sentence,
            'data_previsao' => $dataPrevisao,
            'data_finalizacao' => $dataFinalizacao,
        ];
    }
}
