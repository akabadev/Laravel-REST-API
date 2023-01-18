<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => time() . microtime() . '',
            'bo_reference' => time() . '',
            'name' => $this->faker->company(),
            'contact_name' => $this->faker->name(),
            'active' => $this->faker->boolean(),
            'address_id' => Address::factory(),
        ];
    }
}
