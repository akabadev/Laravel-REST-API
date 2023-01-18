<?php

namespace Database\Factories;

use App\Models\Armament;
use App\Models\Spacecraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArmamentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Armament::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'spacecraft_id' => Spacecraft::factory()->make(),
            'title' => $this->faker->randomElement([ 'Turbo Laser', 'Ion Cannons', 'Tractor Beam' ]),
            'qty' => $this->faker->randomNumber(2),
        ];
    }

    
}
