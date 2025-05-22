<?php

namespace Database\Seeders;

use App\Models\Bonus;
use App\Models\Employee;
use App\Models\JobTitle;
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
        JobTitle::factory()->has(
            Employee::factory()->count(1)->sequence(
            ['salary' => 90000]
        )->has(
            Bonus::factory()->count(3)
            )
        )->create([
            'name' => 'Директор'
        ]);

        JobTitle::factory()->has(Employee::factory()->count(1)->sequence(
            ['salary' => 80000]
        )->has(Bonus::factory()->count(2)))->create([
            'name' => 'Замдиректора'
        ]);

        JobTitle::factory()->has(Employee::factory()->count(2)->sequence(
            ['salary' => 60000],
            ['salary' => 65000],
        )->has(Bonus::factory()->count(1)))->create([
            'name' => 'Менеджер',
        ]);

        JobTitle::factory()->has(Employee::factory()->count(5)->sequence(
            ['salary' => 40000.00],
            ['salary' => 45000.00],
            ['salary' => 43000.00],
            ['salary' => 42000.00],
            ['salary' => 39000.00],
        )->has(Bonus::factory()->count(1)))->create([
            'name' => 'Работник'
        ]);
    }
}
