<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Stancl\Tenancy\Exceptions\TenantDatabaseAlreadyExistsException;

class TenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = explode(',', env('CLIENTS', ''));
        $centralDomain = config('app.url');

        collect($tenants)->map(function ($name) use ($centralDomain) {
            $name = Str::slug(strtolower($name));

            try {
                $tenant = Tenant::firstOrCreate(['id' => $name]);
            } catch (TenantDatabaseAlreadyExistsException  $exception) {
                $tenant = Tenant::findOrFail($name);
            }

            $domain = $name . '.' . $centralDomain;
            $tenant->domains()
                ->firstOrCreate(['domain' => $domain]);
        });
    }
}
