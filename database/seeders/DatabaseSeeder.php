<?php

namespace Database\Seeders;

use App\Models\Chamado;
use App\Models\ComentarioChamado;
use App\Models\Tarefa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SetorSeeder::class,
            AvaliacaoSeeder::class,
        ]);
        // User::factory(50)->create();
        // Chamado::factory(50)->create();
        // Tarefa::factory(50)->create();
        // ComentarioChamado::factory(25)->create();
    }
}
