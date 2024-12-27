<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            ['nome' => 'Compras'],
            ['nome' => 'TI'],
            ['nome' => 'RH'],
            ['nome' => 'Financeiro'],
            ['nome' => 'Marketing'],
            ['nome' => 'Vendas'],
            ['nome' => 'Logística'],
            ['nome' => 'Suporte Técnico'],
            ['nome' => 'Produção'],
            ['nome' => 'Qualidade'],
            ['nome' => 'Jurídico'],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::create($departamento);
        }
    }
}
