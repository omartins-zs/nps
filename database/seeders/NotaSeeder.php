<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 50) as $index) {
            DB::table('notas')->insert([
                'usuario_id' => rand(1, 10), // ID aleatório de usuário
                'nota' => rand(0, 10), // Nota aleatória entre 0 e 10
                'data_resposta' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'), // Data aleatória nos últimos 30 dias
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
