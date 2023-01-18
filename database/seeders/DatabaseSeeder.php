<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FleetSeeder::class);
        $this->call(SpacecraftSeeder::class);
        $this->call(ArmamentSeeder::class);
       // $this->call(PassportClientSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ListingSeeder::class);
        $this->call(ProcessesTableSeeder::class);

        if (app()->environment('local', 'development')) {
            $this->call(TenantTableSeeder::class);
            $this->call(UsersTableSeeder::class);
        }
    }
}
