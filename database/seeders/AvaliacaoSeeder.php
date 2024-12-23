<?php

namespace Database\Seeders;

use App\Models\Avaliacao;
use App\Models\Setor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvaliacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Setor::all()->each(function ($setor) {
            Avaliacao::factory(10)->create([
                'setor_id' => $setor->id,
            ]);
        });
    }
}
