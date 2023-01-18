<?php

namespace Database\Seeders\Tenant;

use App\Models\Pattern;
use Illuminate\Database\Seeder;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pattern::createMany([
            [
                'code' => 'LOGIDOM_V1',
                'pattern' => 'ORDER_[USER]_[JJ][MM][AAAA].txt',
                'description' => 'Nomenclature des fichiers de commande (LOGIDOM V1)'
            ]
        ]);
    }
}
