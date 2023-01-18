<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAndSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-and-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make mass migrations and seeds into the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!app()->environment('local')) {
            $this->error("This command must be Lunched only in Local");
            return 1;
        }

        $this->call("migrate:fresh");
        $this->call("db:seed");
        $this->call("tenants:migrate-fresh");
        $this->call("tenants:seed");

        return self::SUCCESS;
    }
}
