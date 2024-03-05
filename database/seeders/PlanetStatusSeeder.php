<?php

namespace Database\Seeders;

use App\Models\PlanetStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanetStatus::factory(1000)->create();
    }
}
