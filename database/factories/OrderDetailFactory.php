<?php

namespace Database\Factories;

use App\Models\Beneficiary;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(10, 50),
            'delivery_type' => $this->faker->randomElement(['site', 'sur place', 'siège']),
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'beneficiary_id' => Beneficiary::factory(),
            // 'address_id' => Address::factory()
        ];
    }
}
