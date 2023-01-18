<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Beneficiary;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeneficiaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Beneficiary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => time() . microtime() . '',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'profile' => $this->faker->randomElement(Beneficiary::$PROFILES),
            'active' => $this->faker->boolean(),
            'address_id' => $this->faker->randomElement([null, Address::factory()]),
            'service_id' => Service::factory(),
        ];
    }
}
