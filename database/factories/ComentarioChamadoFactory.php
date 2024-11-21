<?php

namespace Database\Factories;

use App\Models\Chamado;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComentarioChamado>
 */
class ComentarioChamadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ticket_id' => Chamado::inRandomOrder()->first()->id, // Associando a um chamado aleatório
            'user_id' => User::inRandomOrder()->first()->id, // Associando a um usuário aleatório
            'comment' => $this->faker->paragraph,
        ];
    }
}
