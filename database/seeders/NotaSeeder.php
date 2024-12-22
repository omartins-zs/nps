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
        $year = date('Y'); // Ano atual

        // Loop pelos 12 meses do ano
        foreach (range(1, 12) as $month) {
            foreach (range(1, 50) as $index) {
                DB::table('notas')->insert([
                    'usuario_id' => rand(1, 10), // ID aleatório de usuário
                    'nota' => rand(0, 10), // Nota aleatória entre 0 e 10
                    'data_resposta' => Carbon::create($year, $month, rand(1, 28))->format('Y-m-d'), // Data aleatória no mês
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
