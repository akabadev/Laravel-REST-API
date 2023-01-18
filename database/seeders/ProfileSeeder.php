<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        profile::createMany([
            [
                'code' => 'ADMIN',
                'name' => 'Administrateur Principal',
                'level' => 1,
            ],
            [
                'code' => 'UP_ADMIN',
                'name' => 'Administrateur Cheque Déjeuner',
                'level' => 2,
            ],
            [
                'code' => 'CUSTOMER_ADMIN',
                'name' => 'Administrateur Client',
                'level' => 3,
            ],
            [
                'code' => 'CUSTOMER_MANAGER',
                'name' => 'Superviseur',
                'level' => 4,
            ],
            [
                'code' => 'SERVICE_MANAGER',
                'name' => 'Gestionnaires de Service',
                'level' => 5,
            ],
            [
                'code' => 'BENEFICIARY',
                'name' => 'Bénéficiaires',
                'level' => 6,
            ],
        ]);
    }
}
