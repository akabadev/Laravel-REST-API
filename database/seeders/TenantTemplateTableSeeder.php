<?php

namespace Database\Seeders;

use App\Models\TenantTemplate;
use Illuminate\Database\Seeder;

class TenantTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TenantTemplate::createMany([
            ['id' => TenantTemplate::DEFAULT_TEMPLATE_ID, 'name' => 'basic'],
        ]);
    }
}
