<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

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
            'template_file' => $this->faker->word(),
        ];
    }
}
