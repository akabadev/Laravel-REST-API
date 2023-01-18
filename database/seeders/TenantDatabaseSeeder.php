<?php

namespace Database\Seeders;

use Database\Seeders\Tenant\BeneficiarySeeder;
use Database\Seeders\Tenant\CustomerSeeder;
use Database\Seeders\Tenant\FormatSeeder;
use Database\Seeders\Tenant\OrderDetailSeeder;
use Database\Seeders\Tenant\PatternSeeder;
use Database\Seeders\Tenant\ProductSeeder;
use Database\Seeders\Tenant\ServiceSeeder;
use Database\Seeders\Tenant\TemplateSeeder;
use Database\Seeders\Tenant\PeriodSeeder;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProfileSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ListingSeeder::class);
        $this->call(ProcessesTableSeeder::class);
        $this->call(FormatSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(PatternSeeder::class);

        if (app()->environment('local', 'development')) {
            $this->call(UsersTableSeeder::class);
            $this->call(BeneficiarySeeder::class);
            $this->call(CustomerSeeder::class);
            $this->call(OrderDetailSeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(ServiceSeeder::class);
            $this->call(PeriodSeeder::class);
        }
    }
}
