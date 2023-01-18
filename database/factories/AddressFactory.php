<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'address_1' => $this->faker->address,
            'address_2' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'town' => $this->faker->city,
            'country' => $this->faker->country,
        ];
    }
}
