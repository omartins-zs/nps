<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Survey;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Department::create(['name' => 'RH']);
        Department::create(['name' => 'TI']);
        Department::create(['name' => 'Compras']);
        Department::create(['name' => 'Almoxarifado']);
        Department::create(['name' => 'Diretoria']);
        Department::create(['name' => 'Marketing']);
    }
}
