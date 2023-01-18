<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'reference' => Str::upper(microtime()),
            'type' => $this->faker->randomElement(['1', '2', '3']),
            'tracking_number' => Str::upper(md5(microtime())),
            'status' => $this->faker->sentence(),
            'validated_at' => Carbon::now(),
            'transmitted_at' => $this->faker->dateTime,
            'produced_at' => $this->faker->dateTime,
            'shipped_at' => $this->faker->dateTime,
            'active' => $this->faker->boolean(),
            'customer_id' => Customer::factory(),
        ];
    }
}
