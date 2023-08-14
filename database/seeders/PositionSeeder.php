<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => "Director",
            'description' => "Director",
            'start_time' => "08:00:00",
            'end_time' => "17:00:00",
            'first_payment' => 16,
            'second_payment' => 1
        ]);
        Position::create([
            'name' => "Coordinador",
            'description' => "Coordinador",
            'start_time' => "10:00:00",
            'end_time' => "17:00:00",
            'first_payment' => 16,
            'second_payment' => 1
        ]);
        Position::create([
            'name' => "Programador",
            'description' => "Programador",
            'start_time' => "08:00:00",
            'end_time' => "17:00:00",
            'first_payment' => 16,
            'second_payment' => 1
        ]);

    }
}
