<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chamado>
 */
class ChamadoFactory extends Factory
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
            'titulo' => $this->faker->sentence,
            'descricao' => $this->faker->paragraph,
            'usuario_criador_id' => User::inRandomOrder()->first()->id, // Associando a um usuário aleatório
            'usuario_responsavel_id' => User::inRandomOrder()->first()->id, // Associando a um usuário aleatório
            'status' => $this->faker->randomElement(['aberto', 'em_andamento', 'concluido']),
            'data_previsao' => $dataPrevisao,
            'data_finalizacao' => $dataFinalizacao,
        ];
    }
}
