<?php

namespace Database\Factories;

use App\Models\Spacecraft;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpacecraftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spacecraft::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([ 'Assassin', 'Devastator', 'Tank', 'Red Five' ]). ' ' .$this->faker->unique()->randomNumber(4),//column is unique
            'class' => $this->faker->randomElement(Spacecraft::CLASSES),
            'crew' => $this->faker->randomNumber(5),
            'image' => $this->faker->md5 . '.' . $this->faker->randomElement([ 'png', 'jpg', 'svg' ]),
            'value' => $this->faker->randomFloat(2, 1000, 5000),
            'status' => $this->faker->randomElement([ Spacecraft::STATUS_OPERATIONAL, Spacecraft::STATUS_DAMAGED ]),
            'fleet_id' => Fleet::factory(),
        ];
    }


}
