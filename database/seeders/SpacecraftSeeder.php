<?php

namespace Database\Seeders;

use App\Models\Spacecraft;
use Illuminate\Database\Seeder;

class SpacecraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spacecraft::factory()->count(10)->create();
    }
}
