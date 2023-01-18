<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numberBetween(1, 1000),
            'bo_reference' => time() . '',
            'name' => $this->faker->company,
            'contact_name' => $this->faker->streetName,
            'delivery_site' => $this->faker->sentence(2),
            'active' => $this->faker->boolean(),
            'address_id' => Address::factory(),
            'customer_id' => Customer::factory(),
        ];
    }
}
