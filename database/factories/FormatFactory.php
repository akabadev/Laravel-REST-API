<?php

namespace Database\Factories;

use App\Models\Format;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Format::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => time() . microtime() . '',
            'name' => $this->faker->name(),
            'description' => $this->faker->text(50),
            'config_file' => $this->faker->word(),
        ];
    }
}
