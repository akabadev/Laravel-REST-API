<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\Period;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Period::class;

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
            'calendar_id' => Calendar::factory(),
        ];
    }
}
