<?php

namespace Database\Seeders\Tenant;

use App\Models\Format;
use App\Models\Order;
use Illuminate\Database\Seeder;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Format::createMany([
            [
                'code' => Order::EXPORT_CODE_FIXED_SIZE,
                'description' => "Commande Taille fixe",
                'name' => "Commande Taille fixe",
                'config_file' => 'exports/orders/logidom_v1.json',
            ]
        ]);
    }
}
